<?php

use Tests\TestCase;

class ArticleIndexTest extends TestCase
{
    private $rawResponse;
    private $response;

    public function testGettingAllArticles(): void
    {
        // 200 json response
        self::assertEquals(200, $this->rawResponse->getStatusCode());
        self::assertEquals('application/json', $this->rawResponse->getHeader('Content-Type')[0]);
    }

    public function testId(): void
    {
        self::assertIsObject($this->response[0]);
        self::assertObjectHasAttribute('id', $this->response[0]);
        self::assertIsInt($this->response[0]->id);
    }

    public function testTitle(): void
    {
        self::assertObjectHasAttribute('title', $this->response[0]);
        self::assertIsString($this->response[0]->title);
    }

    public function testSlug(): void
    {
        self::assertObjectHasAttribute('slug', $this->response[0]);
        self::assertIsString($this->response[0]->slug);
    }

    public function testContent(): void
    {
        self::assertObjectNotHasAttribute('content', $this->response[0]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $request = $this->createRequest('GET', '/v1/articles');
        $this->rawResponse = $this->app->handle($request);
        $this->response = json_decode((string)$this->rawResponse->getBody());
    }

}
