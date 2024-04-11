<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\ConnectionProvider;
use App\Model;

class PostController
{
    private Model\PostTable $postTable;
    public function __construct()
    {
        $connection = ConnectionProvider::getConnection();
        $this->postTable = new Model\PostTable($connection);
    }

    public function index(): void
    {
        require __DIR__ . '/../View/add_post_form.php';
    }

    public function publishPost(array $request): void
    {
        $post = new Model\Post(null, $request['title'], $request['subtitle'], $request['content'], null);
        $this->postTable->add($post);
    }

    public function showPost(array $request): void
    {
        $id = $request['id'] ?? null;
        if ($id === null)
        {
            throw new \InvalidArgumentException('Parameter id is not defined');
        }
        $post = $this->postTable->find((int) $id);
        require __DIR__ . '/../View/post.php';
    }
}