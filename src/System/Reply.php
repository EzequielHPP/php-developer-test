<?php

namespace App\System;


class Reply
{
    /**
     * Send valid (200) response
     * @param $response
     * @param $content
     * @param int $statusCode - Defaults to 200
     * @param bool $jsonOutput - Defaults to true
     * @return mixed
     */
    public function send($response, $content, int $statusCode = 200, bool $jsonOutput = true)
    {
        if ($jsonOutput) {
            $response->getBody()->write(json_encode($content));
        } else {
            $response->getBody()->write($content);
        }
        return $this->printOutResponse($response, $statusCode, $jsonOutput);
    }

    /**
     * Send the response to the view
     *
     * @param $response
     * @param int $statusCode - Defaults to 200
     * @param bool $jsonOutput - Defaults to true
     * @return mixed
     */
    private function printOutResponse($response, int $statusCode = 200, bool $jsonOutput = true)
    {
        if ($jsonOutput) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
        }
        return $response->withStatus($statusCode);
    }

    /**
     * Abort a request and send an error message
     *
     * @param $response
     * @param string|null $failMessage
     * @param int $statusCode - Defaults to 404
     * @return mixed
     */
    public function abort($response, string $failMessage, int $statusCode = 404)
    {
        $response->getBody()->write(json_encode(['error' => $failMessage]));
        return $this->printOutResponse($response, $statusCode);
    }
}
