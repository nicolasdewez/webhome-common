<?php

namespace Ndewez\WebHome\CommonBundle\Client;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractClient.
 */
abstract class AbstractClient
{
    /** @var string */
    private $baseUrl;

    /** @var int */
    private $version;

    /** @var Client */
    protected $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var Serializer */
    protected $serializer;

    /**
     * @param Client $client
     * @param string $baseUrl
     * @param int    $version
     */
    public function __construct(Client $client, $baseUrl, $version = 0)
    {
        $this->client = $client;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->version = $version;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Generates the full URL to call.
     *
     * @param string $endpoint
     *
     * @return string
     */
    public function generateUrl($endpoint)
    {
        return sprintf('%s/v%s/%s', $this->baseUrl, $this->version, ltrim($endpoint, '/'));
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return AbstractClient
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param mixed $content
     *
     * @return string
     */
    protected function serialize($content)
    {
        if (!empty($content)) {
            if (is_object($content)) {
                $content = $this->serializer->serialize($content, 'json');
            }
        }

        return $content;
    }

    /**
     * Deserializes request content.
     *
     * @param ResponseInterface $response
     * @param string            $type
     * @param string            $format
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function deserialize(ResponseInterface $response, $type, $format = 'json')
    {
        try {
            return $this->serializer->deserialize(
                (string) $response->getBody(),
                $type,
                $format
            );
        } catch (\Exception $exception) {
            $this->logger->error(
                '[WebServiceClient] Deserialization problem on webservice call.',
                array(
                    'response' => (string) $response->getBody(),
                    'exception' => $exception,
                )
            );

            throw $exception;
        }
    }
}
