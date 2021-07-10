<?php

use Tests\TestCase;

class ArticleShowTest extends TestCase
{
    private $rawResponse;
    private $response;
    private $mockEntries;

    /**
     * Test a valid url
     */
    public function testGettingSingleArticle(): void
    {
        // 200 response and json response
        self::assertEquals(200, $this->rawResponse->getStatusCode());
        self::assertEquals('application/json', $this->rawResponse->getHeader('Content-Type')[0]);
    }


    public function testId(): void
    {
        self::assertObjectHasAttribute('id', $this->response);
        self::assertIsInt($this->response->id);
    }

    public function testTitle(): void
    {
        self::assertObjectHasAttribute('title', $this->response);
        self::assertIsString($this->response->title);
    }

    public function testSlug(): void
    {
        self::assertObjectHasAttribute('slug', $this->response);
        self::assertIsString($this->response->slug);
    }

    public function testContent(): void
    {
        self::assertObjectHasAttribute('content', $this->response);
    }

    public function testContentObjects(): void
    {
        self::assertObjectHasAttribute('type', $this->response->content[0]);
        self::assertObjectHasAttribute('content', $this->response->content[0]);
        self::assertObjectHasAttribute('children', $this->response->content[0]);
    }

    /**
     * Test an invalid url
     */
    public function testGettingInvalidArticle(): void
    {
        $request = $this->createRequest('GET', '/v1/articles/0');
        $res = $this->app->handle($request);

        // 404 response and json response
        self::assertEquals(404, $res->getStatusCode());
        self::assertEquals('application/json', $res->getHeader('Content-Type')[0]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $sep = DIRECTORY_SEPARATOR;
        $file = __DIR__ . $sep . 'Models' . $sep . 'articles.json';
        $articles = json_decode(file_get_contents($file));
        shuffle($articles);
        $this->mockEntries = array_values($articles);

        $request = $this->createRequest('GET', '/v1/articles/' . $this->mockEntries[0]->id);
        $this->rawResponse = $this->app->handle($request);
        $this->response = json_decode((string)$this->rawResponse->getBody());
    }
}
