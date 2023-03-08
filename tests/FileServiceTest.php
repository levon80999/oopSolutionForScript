<?php

declare(strict_types = 1);

namespace tests;

use App\Services\FileService\FileService;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FileServiceTest extends TestCase
{
    /**
     * set up test environmemt
     *
     * @var MockObject
     */
    private MockObject $fileService;

    /**
     * @var vfsStreamDirectory
     */
    private vfsStreamDirectory $file_system;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $directory = [
            'testing' => [
                'input.txt' => '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
                'empty.txt' => '',
            ]
        ];
        $this->file_system = vfsStream::setup('root', 444, $directory);

        parent::setUp();
    }

    public function testGetFileContent_existingFile_ReturnsFileContent(): void
    {
        $fileService = new FileService();
        $result = $fileService->getFileContent($this->file_system->url().'/testing/input.txt');
        $content = json_decode($result, true);

        $this->assertEquals('45717360', $content['bin']);
        $this->assertEquals('100.00', $content['amount']);
        $this->assertEquals('EUR', $content['currency']);
    }

    public function testGetFileContent_notExistingFile_ReturnsFalse(): void
    {
        $fileService = new FileService();
        $result = $fileService->getFileContent($this->file_system->url().'/testing/non-exists.txt');

        $this->assertFalse($result);
    }

    public function testGetFileContent_EmptyExistingFile_ReturnsEmptyString(): void
    {
        $fileService = new FileService();
        $result = $fileService->getFileContent($this->file_system->url().'/testing/empty.txt');

        $this->assertEquals('', $result);
    }
}