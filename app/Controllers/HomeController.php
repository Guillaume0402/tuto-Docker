<?php

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Accueil - Tuto Docker',
            'description' => 'Apprenez Docker avec nos tutoriels interactifs'
        ];

        $this->view('home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'À propos - Tuto Docker',
            'description' => 'Découvrez notre mission et notre équipe'
        ];

        $this->view('about', $data);
    }
}
