<?php
enum Page
{
    case Menu;
    case Vitrine;
    case Inscription;
    case Connexion;
    case Profil;
    case Aide;
    case Inventaire;
    case Enigma;
    case Details;
    case Reviews;

    public function text(): string{
        return match($this){
            Page::Menu => 'Menu',
            Page::Vitrine => 'Vitrine',
            Page::Inscription => 'Inscription',
            Page::Connexion => 'Connexion',
            Page::Profil => 'Votre profil',
            Page::Aide => 'Contact admin',
            Page::Inventaire => 'Inventaire',
            Page::Enigma => 'Enigmes',
            Page::Details => 'Details', 
            Page::Reviews => 'Reviews'
        };
    }

    public function url(): string{
        return match($this){
            Page::Menu => '/',
            Page::Vitrine => '/vitrine.php',
            Page::Details => '/details.php',
            Page::Reviews => 'reviews.php'
        };
    }
}
?>