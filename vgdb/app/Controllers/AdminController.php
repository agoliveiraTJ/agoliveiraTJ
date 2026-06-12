<?php

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $videoGameModel = new VideoGame();
        $jogoModel = new Jogo();

        $this->view('admin/dashboard', [
            'title' => 'Painel Administrativo',
            'totalVideoGames' => $videoGameModel->count(),
            'totalJogos' => $jogoModel->count(),
        ]);
    }
}
