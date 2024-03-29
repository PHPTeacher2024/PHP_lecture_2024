<?php
declare(strict_types=1);

require_once __DIR__ . '/PostInterface.php';

class Post implements PostInterface
{
    private ?int $id;
    private string $title;
    private string $subTitle;
    private string $content;
    public ?DateTimeImmutable $postedAt;

    public function __construct(?int $id, string $title, string $subTitle, string $content, ?DateTimeImmutable $postedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->content = $content;
        $this->postedAt = $postedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPostedAt(): ?DateTimeImmutable
    {
        return $this->postedAt;
    }
}