<?php
declare(strict_types=1);

namespace App\Model;

class ModernPost implements PostInterface
{
    public function __construct(private ?int $id, private string $title, private string $subTitle, private string $content, private ?\DateTimeImmutable $postedAt)
    {
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

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }
}