<?php

namespace Ndewez\WebHome\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AbstractController.
 */
abstract class AbstractController extends Controller
{
    /**
     * @param Request $request
     *
     * @throws BadRequestHttpException
     */
    public function assertXmlHttpRequest(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException();
        }
    }
}
