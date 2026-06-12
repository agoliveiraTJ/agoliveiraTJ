<?php

class VideoGameController extends Controller
{
    private VideoGame $videoGameModel;
    private Jogo $jogoModel;

    public function __construct()
    {
        $this->videoGameModel = new VideoGame();
        $this->jogoModel = new Jogo();
    }

    public function index(): void
    {
        $this->view('videogames/index', [
            'title' => 'Video Games',
            'videoGames' => $this->videoGameModel->all(),
        ]);
    }

    public function show(int $id): void
    {
        $videoGame = $this->videoGameModel->find($id);

        if (!$videoGame) {
            http_response_code(404);
            (new HomeController())->notFound();
            return;
        }

        $this->view('videogames/show', [
            'title' => $videoGame['nome'],
            'videoGame' => $videoGame,
            'jogos' => $this->jogoModel->byVideoGame($id),
        ]);
    }

    public function adminIndex(): void
    {
        [$sort, $direction] = $this->sortParams(
            ['id', 'nome', 'fabricante', 'ano_lancamento', 'midia'],
            'nome'
        );

        $this->view('admin/videogames/index', [
            'title' => 'Gerenciar Video Games',
            'videoGames' => $this->videoGameModel->all($sort, $direction),
            'currentSort' => $sort,
            'currentDirection' => $direction,
        ]);
    }

    public function create(): void
    {
        $this->view('admin/videogames/form', [
            'title' => 'Novo Video Game',
            'videoGame' => null,
            'errors' => [],
        ]);
    }

    public function store(): void
    {
        $data = $this->sanitizeData($_POST);
        $errors = $this->validate($data);

        try {
            $data['imagem'] = UploadHelper::uploadImage($_FILES['imagem'] ?? []);
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }

        if ($errors) {
            $this->view('admin/videogames/form', [
                'title' => 'Novo Video Game',
                'videoGame' => $data,
                'errors' => $errors,
            ]);
            return;
        }

        $this->videoGameModel->create($data);
        $this->flash('success', 'Video Game cadastrado com sucesso.');
        $this->redirect('/admin/videogames');
    }

    public function edit(int $id): void
    {
        $videoGame = $this->videoGameModel->find($id);

        if (!$videoGame) {
            $this->flash('error', 'Video Game nao encontrado.');
            $this->redirect('/admin/videogames');
        }

        $this->view('admin/videogames/form', [
            'title' => 'Editar Video Game',
            'videoGame' => $videoGame,
            'errors' => [],
        ]);
    }

    public function update(int $id): void
    {
        $current = $this->videoGameModel->find($id);

        if (!$current) {
            $this->flash('error', 'Video Game nao encontrado.');
            $this->redirect('/admin/videogames');
        }

        $data = $this->sanitizeData($_POST);
        $errors = $this->validate($data);
        $data['imagem'] = $current['imagem'];

        try {
            $newImage = UploadHelper::uploadImage($_FILES['imagem'] ?? []);
            if ($newImage) {
                $data['imagem'] = $newImage;
            }
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }

        if ($errors) {
            $data['id'] = $id;
            $this->view('admin/videogames/form', [
                'title' => 'Editar Video Game',
                'videoGame' => $data,
                'errors' => $errors,
            ]);
            return;
        }

        $this->videoGameModel->update($id, $data);
        $this->flash('success', 'Video Game atualizado com sucesso.');
        $this->redirect('/admin/videogames');
    }

    public function destroy(int $id): void
    {
        $this->videoGameModel->delete($id);
        $this->flash('success', 'Video Game excluido com sucesso.');
        $this->redirect('/admin/videogames');
    }

    private function sanitizeData(array $input): array
    {
        $anoLancamento = trim((string)($input['ano_lancamento'] ?? ''));

        return [
            'nome' => trim($input['nome'] ?? ''),
            'fabricante' => trim($input['fabricante'] ?? ''),
            'geracao' => trim($input['geracao'] ?? ''),
            'ano_lancamento' => $anoLancamento !== '' ? (int)$anoLancamento : null,
            'midia' => trim($input['midia'] ?? ''),
            'descricao' => trim($input['descricao'] ?? ''),
            'imagem' => null,
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['nome'] === '') {
            $errors[] = 'Informe o nome do Video Game.';
        }

        if ($data['fabricante'] === '') {
            $errors[] = 'Informe o fabricante.';
        }

        if (!$data['ano_lancamento'] || $data['ano_lancamento'] < 1970 || $data['ano_lancamento'] > 2100) {
            $errors[] = 'Informe um ano de lancamento valido.';
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
