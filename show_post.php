<?php

require_once __DIR__ . '/vendor/autoload.php';

$controller = new \App\Controller\PostController();
$controller->showPost($_GET);
