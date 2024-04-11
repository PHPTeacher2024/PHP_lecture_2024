<?php
declare(strict_types=1);

namespace App\Model;

class FriendlyPost extends Post
{
    public function __construct(?int $id, string $title, string $subTitle, string $content, ?\DateTimeImmutable $postedAt)
    {
        parent::__construct($id, $title, $subTitle, $content, $postedAt);
    }

    public function getContent(): string
    {
        return 'Hello, Dear!' . parent::getContent();
    }
}