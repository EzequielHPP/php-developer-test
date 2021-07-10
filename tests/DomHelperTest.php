<?php

use Tests\TestCase;

class DomConverterTest extends TestCase
{
    private $helper;
    private $dom;

    public function testParagraphConversion(): void
    {
        $html = '<p>Test</p>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertParagraph($this->dom->firstChild());

        self::assertIsArray($response);
    }

    public function testParagraphTypeKey(): void
    {
        $html = '<p>Test</p>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertParagraph($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('paragraph', $response['type']);
    }

    public function testParagraphContentKey(): void
    {
        $html = '<p>Test</p>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertParagraph($this->dom->firstChild());

        self::assertArrayHasKey('content', $response);
        self::assertEquals('Test', $response['content']);
    }

    public function testTextConversion(): void
    {
        $html = '<span>Test</span>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertText($this->dom->firstChild());

        self::assertIsArray($response);
        self::assertArrayHasKey('type', $response);
        self::assertEquals('text', $response['type']);
        self::assertArrayHasKey('content', $response);
        self::assertEquals('Test', $response['content']);
    }

    public function testTextTypeKey(): void
    {
        $html = '<span>Test</span>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertText($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('text', $response['type']);
    }

    public function testTextContentKey(): void
    {
        $html = '<span>Test</span>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertText($this->dom->firstChild());

        self::assertArrayHasKey('content', $response);
        self::assertEquals('Test', $response['content']);
    }

    public function testHeaderConversion(): void
    {
        $html = '<h3>Test</h3>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertHeaderTag($this->dom->firstChild());

        self::assertIsArray($response);
    }

    public function testHeaderTypeKey(): void
    {
        $html = '<h3>Test</h3>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertHeaderTag($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('headingThree', $response['type']);
    }

    public function testHeaderContentKey(): void
    {
        $html = '<h3>Test</h3>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertHeaderTag($this->dom->firstChild());

        self::assertArrayHasKey('content', $response);
        self::assertEquals('Test', $response['content']);
    }

    public function testHeaderStyleKey(): void
    {
        $html = '<h3 style="color: black">Test</h3>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertHeaderTag($this->dom->firstChild());

        self::assertArrayHasKey('style', $response);
        self::assertEquals('color: black', $response['style']);
    }

    public function testBoldConversion(): void
    {
        $html = '<b>Test</b>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertBoldTag($this->dom->firstChild());

        self::assertIsArray($response);
    }

    public function testBoldTypeKey(): void
    {
        $html = '<b>Test</b>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertBoldTag($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('bold', $response['type']);
    }

    public function testBoldContentKey(): void
    {
        $html = '<b>Test</b>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertBoldTag($this->dom->firstChild());

        self::assertArrayHasKey('content', $response);
        self::assertEquals('Test', $response['content']);
    }

    public function testImageConversion(): void
    {
        $html = '<img src="test.jpg" alt="alt text">';
        $this->dom->loadStr($html);
        $response = $this->helper::convertImageTag($this->dom->firstChild());

        self::assertIsArray($response);
    }

    public function testImageTypeKey(): void
    {
        $html = '<img src="test.jpg" alt="alt text">';
        $this->dom->loadStr($html);
        $response = $this->helper::convertImageTag($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('image', $response['type']);
    }

    public function testImageSrcKey(): void
    {
        $html = '<img src="test.jpg" alt="alt text">';
        $this->dom->loadStr($html);
        $response = $this->helper::convertImageTag($this->dom->firstChild());

        self::assertArrayHasKey('src', $response);
        self::assertEquals('test.jpg', $response['src']);
    }

    public function testImageAltTextKey(): void
    {
        $html = '<img src="test.jpg" alt="alt text">';
        $this->dom->loadStr($html);
        $response = $this->helper::convertImageTag($this->dom->firstChild());

        self::assertArrayHasKey('altText', $response);
        self::assertEquals('alt text', $response['altText']);
    }



    public function testIframeConversion(): void
    {
        $html = '<iframe src="https://www.youtube.com/embed/ITvvBS9VMLk?list=PLuMAo-oYl9zinQLZOLludvdORZqvhd6w4" frameborder="0" width="560" height="315"></iframe>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertIframeTag($this->dom->firstChild());

        self::assertIsArray($response);
    }

    public function testIframeTypeKey(): void
    {
        $html = '<iframe src="https://www.youtube.com/embed/ITvvBS9VMLk?list=PLuMAo-oYl9zinQLZOLludvdORZqvhd6w4" frameborder="0" width="560" height="315"></iframe>';
        $this->dom->loadStr($html);
        $response = $this->helper::convertIframeTag($this->dom->firstChild());

        self::assertArrayHasKey('type', $response);
        self::assertEquals('iframe', $response['type']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new \App\Helpers\DomConverter();
        $this->dom = new \PHPHtmlParser\Dom();
    }

}
