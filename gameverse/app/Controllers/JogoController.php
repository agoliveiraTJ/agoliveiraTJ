<?php

class JogoController extends Controller
{
    private Jogo $jogoModel;
    private VideoGame $videoGameModel;

    public function __construct()
    {
        $this->jogoModel = new Jogo();
        $this->videoGameModel = new VideoGame();
    }

    public function index(): void
    {
        $this->view('jogos/index', [
            'title' => 'Jogos',
            'jogos' => $this->jogoModel->all(),
        ]);
    }

    public function show(int $id): void
    {
        $jogo = $this->jogoModel->findWithPlatforms($id);

        if (!$jogo) {
            http_response_code(404);
            (new HomeController())->notFound();
            return;
        }

        $this->view('jogos/show', [
            'title' => $jogo['titulo'],
            'jogo' => $jogo,
        ]);
    }

    public function adminIndex(): void
    {
        [$sort, $direction] = $this->sortParams(
            ['titulo', 'genero', 'ano_lancamento', 'plataformas'],
            'titulo'
        );

        $this->view('admin/jogos/index', [
            'title' => 'Gerenciar Jogos',
            'jogos' => $this->jogoModel->all($sort, $direction),
            'currentSort' => $sort,
            'currentDirection' => $direction,
        ]);
    }

    public function create(): void
    {
        $this->view('admin/jogos/form', [
            'title' => 'Novo Jogo',
            'jogo' => null,
            'videoGames' => $this->videoGameModel->all(),
            'selectedVideoGames' => [],
            'errors' => [],
        ]);
    }

    public function store(): void
    {
        $data = $this->sanitizeData($_POST);
        $platformIds = $_POST['video_games'] ?? [];
        $errors = $this->validate($data, $platformIds);

        try {
            $data['capa'] = UploadHelper::uploadImage($_FILES['capa'] ?? []);
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }

        if ($errors) {
            $this->view('admin/jogos/form', [
                'title' => 'Novo Jogo',
                'jogo' => $data,
                'videoGames' => $this->videoGameModel->all(),
                'selectedVideoGames' => array_map('intval', $platformIds),
                'errors' => $errors,
            ]);
            return;
        }

        $this->jogoModel->create($data, $platformIds);
        $this->flash('success', 'Jogo cadastrado com sucesso.');
        $this->redirect('/admin/jogos');
    }

    public function edit(int $id): void
    {
        $jogo = $this->jogoModel->find($id);

        if (!$jogo) {
            $this->flash('error', 'Jogo nao encontrado.');
            $this->redirect('/admin/jogos');
        }

        $this->view('admin/jogos/form', [
            'title' => 'Editar Jogo',
            'jogo' => $jogo,
            'videoGames' => $this->videoGameModel->all(),
            'selectedVideoGames' => $this->jogoModel->platformIds($id),
            'errors' => [],
        ]);
    }

    public function update(int $id): void
    {
        $current = $this->jogoModel->find($id);

        if (!$current) {
            $this->flash('error', 'Jogo nao encontrado.');
            $this->redirect('/admin/jogos');
        }

        $data = $this->sanitizeData($_POST);
        $platformIds = $_POST['video_games'] ?? [];
        $errors = $this->validate($data, $platformIds);
        $data['capa'] = $current['capa'];

        try {
            $newImage = UploadHelper::uploadImage($_FILES['capa'] ?? []);
            if ($newImage) {
                $data['capa'] = $newImage;
            }
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }

        if ($errors) {
            $data['id'] = $id;
            $this->view('admin/jogos/form', [
                'title' => 'Editar Jogo',
                'jogo' => $data,
                'videoGames' => $this->videoGameModel->all(),
                'selectedVideoGames' => array_map('intval', $platformIds),
                'errors' => $errors,
            ]);
            return;
        }

        $this->jogoModel->update($id, $data, $platformIds);
        $this->flash('success', 'Jogo atualizado com sucesso.');
        $this->redirect('/admin/jogos');
    }

    public function destroy(int $id): void
    {
        $this->jogoModel->delete($id);
        $this->flash('success', 'Jogo excluido com sucesso.');
        $this->redirect('/admin/jogos');
    }

    private function sanitizeData(array $input): array
    {
        $anoLancamento = trim((string)($input['ano_lancamento'] ?? ''));

        return [
            'titulo' => trim($input['titulo'] ?? ''),
            'genero' => trim($input['genero'] ?? ''),
            'desenvolvedora' => trim($input['desenvolvedora'] ?? ''),
            'publicadora' => trim($input['publicadora'] ?? ''),
            'ano_lancamento' => $anoLancamento !== '' ? (int)$anoLancamento : null,
            'classificacao_indicativa' => trim($input['classificacao_indicativa'] ?? ''),
            'modo_jogo' => trim($input['modo_jogo'] ?? ''),
            'descricao' => trim($input['descricao'] ?? ''),
            'capa' => null,
        ];
    }

    private function validate(array $data, array $platformIds): array
    {
        $errors = [];

        if ($data['titulo'] === '') {
            $errors[] = 'Informe o titulo do jogo.';
        }

        if ($data['genero'] === '') {
            $errors[] = 'Informe o genero.';
        }

        if (!$data['ano_lancamento'] || $data['ano_lancamento'] < 1970 || $data['ano_lancamento'] > 2100) {
            $errors[] = 'Informe um ano de lancamento valido.';
        }

        if (!$platformIds) {
            $errors[] = 'Selecione pelo menos um Video Game.';
        }

        return $errors;
    }

    private function sortParams(array $allowedSorts, string $defaultSort): array
    {
        $sort = $_GET['sort'] ?? $defaultSort;
        $direction = strtolower($_GET['direction'] ?? 'asc');

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = $defaultSort;
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        return [$sort, $direction];
    }
}
