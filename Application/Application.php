<?php

declare(strict_types = 1);

namespace App;

use App\Services\FileService\FileService;
use App\Services\Parser\JsonParser;
use App\Services\Parser\Parser;
use App\Services\Remote\Fetch;
use Exception;

class Application
{
    /**
     * @var Application
     */
    private static Application $instance;

    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * @var Parser
     */
    private Parser $parser;

    /**
     * @var mixed|null
     */
    private mixed $config;

    /**
     * @throws Exception
     */
    private function __construct() {
        $this->fileService = new FileService();
        $jsonParser = new JsonParser();
        $this->parser = new Parser($jsonParser);

        $registry = Registry::getInstance();
        $registry->getApplicationHelper()->init();
        $this->config = $registry->get('config');
    }

    public static function getInstance() : Application
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new static();

        return self::$instance;
    }

    /**
     * @param string $path
     * @return void
     */
    public function run(string $path): void
    {
        // Get file Content
        $result = $this->fileService->getFileContent($path);

        // Parse File Content
        $data = $this->parser->getResult($result);

        /** @var TYPE_NAME $exception */
        try {

            $client = new Fetch();
            $rate = $client->get("{$this->config['exchangerates_url']}?access_key=".$this->config['access_key'], [], [
                'Content-Type' => 'text/plain',
                'apiKey' => $this->config['access_key']
            ]);

            if (empty($rate)) {
                throw new Exception('Something went wrong');
            }

            foreach ($data as $item) {
                $client = new Fetch();
                $binResults  = $client->get("{$this->config['binlist_url']}/{$item['bin']}");
                $isEu = isEu($binResults['country']['alpha2']);

                echo calculateCommission($item['currency'], $rate['rates'][$item['currency']], (float) $item['amount'], $isEu)."\n";
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}