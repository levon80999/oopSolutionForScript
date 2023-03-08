<?php

declare(strict_types = 1);

namespace App\Services\FileService;

use function file_get_contents;
use function rootPath;

class FileService
{
    /**
     * Responsible to read file and return content.
     *
     * @param string $path
     * @return string|bool
     */
    public function getFileContent(string $path): string|bool
    {
        return file_get_contents(rootPath($path), true);
    }
}