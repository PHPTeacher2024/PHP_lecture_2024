<?php
declare(strict_types=1);

interface PostInterface
{
    public function getId(): ?int;
    public function getTitle(): string;
    public function getSubTitle(): string;
    public function getContent(): string;
    public function getPostedAt(): ?DateTimeImmutable;
}