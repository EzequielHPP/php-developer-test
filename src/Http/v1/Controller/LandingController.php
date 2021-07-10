<?php


namespace App\Http\v1\Controller;


use App\System\Reply;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LandingController extends Reply
{

    /**
     * Hello world landing page and catch all
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response, $path = null): Response
    {
        if(empty($path)) {
            return $this->send($response, __('hello_world'), 200, false);
        }
        return $this->abort($response, __('url_404'));
    }

    /**
     * V1 landing page
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function v1(Request $request, Response $response): Response
    {
        return $this->send($response, __('v1_hello'), 200, false);
    }
}
