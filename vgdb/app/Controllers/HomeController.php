<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $videoGameModel = new VideoGame();
        $jogoModel = new Jogo();

        $this->view('home/index', [
            'title' => 'GameVerse',
            'videoGames' => $videoGameModel->latest(),
            'jogos' => $jogoModel->latest(),
        ]);
    }

    public function notFound(): void
    {
        $this->view('errors/404', [
            'title' => 'Pagina nao encontrada',
        ]);
    }

    public function databaseError(PDOException $exception): void
    {
        $this->view('errors/database', [
            'title' => 'Erro de banco de dados',
            'message' => $exception->getMessage(),
        ]);
    }
}
