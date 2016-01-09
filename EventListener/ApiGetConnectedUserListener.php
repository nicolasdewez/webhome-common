<?php

namespace Ndewez\WebHome\CommonBundle\EventListener;

use Ndewez\WebHome\AuthApiBundle\V0\Service\WebHomeAuthClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiGetConnectedUserListener.
 */
class ApiGetConnectedUserListener implements EventSubscriberInterface
{
    const HEADER_TOKEN = 'HEADER';
    const GET_TOKEN = 'GET';

    /** @var WebHomeAuthClient */
    private $webHomeAuthClient;

    /** @var array */
    private $requiredPaths;

    /** @var array */
    private $optionalPaths;

    /** @var array */
    private $tokens;

    /** @var string */
    private $sessionKey;

    /**
     * @param WebHomeAuthClient $webHomeAuthClient
     * @param string            $sessionKey
     * @param string            $headerToken
     * @param string            $getToken
     */
    public function __construct(WebHomeAuthClient $webHomeAuthClient, $sessionKey = '', $headerToken = '', $getToken = '')
    {
        $this->webHomeAuthClient = $webHomeAuthClient;
        $this->sessionKey = $sessionKey;
        $this->setTokens($headerToken, $getToken);
        $this->requiredPaths = [];
        $this->optionalPaths = [];
    }

    /**
     * @param string $path
     */
    public function addRequiredPath($path)
    {
        $this->requiredPaths[] = $path;
    }

    /**
     * @param string $path
     */
    public function addOptionalPath($path)
    {
        $this->optionalPaths[] = $path;
    }

    /**
     * @param string $header
     * @param string $get
     */
    private function setTokens($header, $get)
    {
        $this->tokens = [
            self::HEADER_TOKEN => $header,
            self::GET_TOKEN => $get,
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $pathInfo = $request->getPathInfo();
        $required = $optional = false;

        // Get access token
        $accessToken = $request->headers->get($this->tokens[self::HEADER_TOKEN]);
        if (null === $accessToken) {
            $accessToken = $request->query->get($this->tokens[self::GET_TOKEN]);
        }

        // Required paths
        if ($this->inPaths($pathInfo, $this->requiredPaths)) {
            $required = true;
            if (null === $accessToken) {
                throw new \InvalidArgumentException('No access token for required path');
            }
        }

        // Optional paths
        if (!$required && $this->inPaths($pathInfo, $this->optionalPaths)) {
            $optional = true;
            if (null === $accessToken) {
                return;
            }
        }

        // Not in required paths, not in optional paths
        if (!$required && !$optional) {
            return;
        }

        // Get user and set in session
        $request->getSession()->set($this->sessionKey, $this->webHomeAuthClient->getByAccessToken($accessToken));
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Firewall listener
            KernelEvents::REQUEST => [['onKernelRequest', 9]],
        );
    }

    /**
     * @param string $pathInfo
     * @param array  $paths
     *
     * @return bool
     */
    private function inPaths($pathInfo, array $paths)
    {
        foreach ($paths as $path) {
            if (preg_match('#'.$path.'#', $pathInfo)) {
                return true;
            }
        }

        return false;
    }
}
