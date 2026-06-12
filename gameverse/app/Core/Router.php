<?php

class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->add('GET', $path, $action);
    }

    public function post(string $path, array $action): void
    {
        $this->add('POST', $path, $action);
    }

    private function add(string $method, string $path, array $action): void
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[0-9]+)', $path);

        $this->routes[] = [
            'method' => $method,
            'pattern' => '#^' . $pattern . '$#',
            'action' => $action,
        ];
    }

    public function dispatch(string $method, string $requestPath): void
    {
        $path = $this->normalizePath($requestPath);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                [$controllerName, $methodName] = $route['action'];
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $controller = new $controllerName();
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        http_response_code(404);
        (new HomeController())->notFound();
    }

    private function normalizePath(string $requestPath): string
    {
        $path = parse_url($requestPath, PHP_URL_PATH) ?: '/';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));

        if ($scriptDir !== '/' && $scriptDir !== '.' && substr($path, 0, strlen($scriptDir)) === $scriptDir) {
            $path = substr($path, strlen($scriptDir));
        }

        $path = '/' . trim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }
}
