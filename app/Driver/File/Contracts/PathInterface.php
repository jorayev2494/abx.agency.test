<?php

declare(strict_types=1);

namespace App\Driver\File\Contracts;

interface PathInterface
{
    public function getPath(): string;

    public function getFullPath(): string;
}