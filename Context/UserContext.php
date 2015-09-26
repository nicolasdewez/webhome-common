<?php

namespace Ndewez\WebHome\CommonBundle\Context;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class UserContext.
 */
class UserContext implements ContextInterface
{
    const USER_LOCALE = 'webhome.user_locale';

    protected $requestStack;
    protected $translator;

    /**
     * @param RequestStack        $requestStack
     * @param TranslatorInterface $translator
     */
    public function __construct(RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return $this->getSession()->get(self::USER_LOCALE, null);
    }

    /**
     * {@inheritDoc}
     */
    public function setLocale($locale)
    {
        $this->translator->setLocale($locale);

        return $this->set(self::USER_LOCALE, $locale);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function set($key, $value)
    {
        $session = $this->getSession();

        if (null !== $value) {
            return $session->set($key, $value);
        }

        if ($session->has($key)) {
            return $session->remove($key);
        }

        return;
    }

    /**
     * @return SessionInterface
     */
    private function getSession()
    {
        return $this->requestStack->getCurrentRequest()->getSession();
    }
}
