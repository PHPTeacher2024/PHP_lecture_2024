<?php
declare(strict_types=1);

require_once __DIR__ . '/Post.php';

class FriendlyPost extends Post
{
    public function __construct(?int $id, string $title, string $subTitle, string $content, ?DateTimeImmutable $postedAt)
    {
        parent::__construct($id, $title, $subTitle, $content, $postedAt);
    }

    public function getContent(): string
    {
        return 'Hello, Dear!' . parent::getContent();
    }
}