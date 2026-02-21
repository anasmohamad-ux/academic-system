<?php
namespace App\Domain\Entities;

class Enrollment
{

    public function __construct(
        public readonly ?int $id,
        public int $userId,
        public int $courseId,
    ) {
    }

}