<?php

use Tests\TestCase;

class StringHelperTest extends TestCase
{
    private $helper;

    public function testCleanHtml(): void
    {
        $html = "    <p>Test</p>\n<p>Something</p>   ";
        $response = $this->helper::cleanHtml($html);

        self::assertEquals('<p>Test</p><br /><p>Something</p>', $response);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new \App\Helpers\StringHelper();
    }

}
