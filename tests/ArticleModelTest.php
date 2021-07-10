<?php

use Tests\TestCase;

class ArticleModelTest extends TestCase
{
    private $model;
    private $filePath;
    private $mockEntries;

    protected function setUp(): void
    {
        parent::setUp();
        $sep = DIRECTORY_SEPARATOR;
        $this->filePath = __DIR__ . $sep . 'Models' . $sep . 'articles.json';
        $this->model = (new \App\Model\Article($this->filePath));

        $articles = json_decode(file_get_contents($this->filePath));
        shuffle($articles);
        $this->mockEntries = array_values($articles);
    }

    public function testGettingAllEntries(): void
    {
        $articles = $this->model->get();

        self::assertIsArray($articles);
        self::assertNotEmpty($articles);
    }

    public function testGettingSingleEntry(): void
    {
        $article = $this->model->find($this->mockEntries[0]->id);

        self::assertIsObject($article);
    }

    public function testIdOfEntry(): void
    {

        $article = $this->model->find($this->mockEntries[0]->id);

        self::assertObjectHasAttribute('id', $article);
    }

    public function testIfMatchesId(): void
    {
        $article = $this->model->find($this->mockEntries[0]->id);
        self::assertEquals($this->mockEntries[0]->id, $article->id);
    }

    public function testGettingInvalidSingleEntry(): void
    {
        $article = $this->model->find(0);

        self::assertNull($article);

    }

}
