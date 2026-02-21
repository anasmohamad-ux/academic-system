<?php

namespace App\Domain\Entities;

class Course
{
    public function __construct(
        public readonly ?int $id,
        public string $title,
        public ?string $description,
        public int $createdBy
    ) {
    }
}
