<?php

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testIndexReturnsText(): void
    {
        $request = $this->createRequest('GET', '/');
        $res = $this->app->handle($request);

        self::assertEquals(__('hello_world'), (string)$res->getBody());
    }
    public function testV1ReturnsText(): void
    {
        $request = $this->createRequest('GET', '/v1');
        $res = $this->app->handle($request);

        self::assertEquals(__('v1_hello'), (string)$res->getBody());
    }

}
