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

    public function text(): string{
        return match($this){
            Page::Menu => 'Menu',
            Page::Vitrine => 'Vitrine',
            Page::Inscription => 'Inscription',
            Page::Connexion => 'Connexion',
            Page::Profil => 'Votre profil',
            Page::Aide => 'Contact admin',
            Page::Inventaire => 'Inventaire',
            Page::Enigma => 'Enigmes'  
        };
    }

    public function url(): string{
        return match($this){
            Page::Menu => '/',
            Page::Inventaire => '/inventaire.php',
        };
    }
}
?>