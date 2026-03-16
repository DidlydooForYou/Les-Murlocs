<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT', dirname(__DIR__));

const TEMPLATE = ROOT . '/template';
const CORE = ROOT . '/core';
const SOURCE = ROOT . '/source';

const URL_ROOT = '/';

const CSS = URL_ROOT . 'css';
const INVENTAIRE_IMG = URL_ROOT . 'items_img';

define('IS_POST', $_SERVER['REQUEST_METHOD'] === 'POST');
define('IS_AUTH', isset($_SESSION['id']));
define('IS_ADMIN', IS_AUTH && $_SESSION['role'] === 1);

const PASSWORD_SIZE = 8;
const MATCH_PATTERN ='/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/';
?>