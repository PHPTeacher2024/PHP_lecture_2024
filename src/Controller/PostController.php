<?php
declare(strict_types=1);

require_once __DIR__ . '/../Model/Post.php';
require_once __DIR__ . '/../Model/PostTable.php';
require_once __DIR__ . '/../Model/ConnectionProvider.php';

class PostController
{
    public function __construct()
    {
        $connection = ConnectionProvider::getConnection();
        $this->postTable = new PostTable($connection);
    }

    public function index(): void
    {
        require __DIR__ . '/../View/add_post_form.php';
    }

    public function publishPost(array $request): void
    {
        $post = new Post(null, $request['title'], $request['subtitle'], $request['content'], null);
        $this->postTable->add($post);
    }

    public function showPost(array $request): void
    {
        $id = $request['id'] ?? null;
        if ($id === null)
        {
            throw new InvalidArgumentException('Parameter id is not defined');
        }
        $post = $this->postTable->find((int) $id);
        require __DIR__ . '/../View/post.php';
    }
}