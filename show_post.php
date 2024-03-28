<?php

require_once __DIR__ . '/src/Controller/PostController.php';

$controller = new PostController();
$controller->showPost($_GET);
