<?php

namespace Dykyi;

use Dykyi\Exception\ClientException;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class BaseClient
 * @package Dykyi
 */
abstract class BaseClient implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ResponseDataExtractor
     */
    protected $extractor;

    /**
     * @var ClientInterface
     */
    protected $client = null;

    /**
     * BaseClient constructor.
     *
     * @param LoggerInterface|null $logger
     * @param ClientInterface $client
     * @param ResponseDataExtractor $extractor
     *
     * @throws ClientException
     */
    public function __construct(ClientInterface $client, ResponseDataExtractor $extractor, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->extractor = $extractor;
        $this->logger = $logger ?: new NullLogger();


    }
    /**
     * Init env
     */
    protected function initEnv()
    {
        if (!file_exists(__DIR__.'/../.env')) {
            throw new ClientException(sprintf('File %s not found!', '.env'));
        }
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
        $dotenv->load();
    }

    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}