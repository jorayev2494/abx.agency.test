<?php

namespace App\Driver\File\Contracts;

interface FileInterface extends PathInterface
{
    public function getFileName(): string;

    public function getMimeType(): string;

    public function getUrl(): string;

    public function getUrlPattern(): string;
}