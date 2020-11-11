<?php

namespace spresnac\Helper\URL;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class ContentHelperTest extends TestCase
{
    /** @test */
    public function it_can_receive_and_return_data_on_construct()
    {
        $contentHelper = new ContentHelper('Test Test');
        $this->assertEquals('Test Test', $contentHelper->getContent());
    }

    /** @test */
    public function it_can_receive_and_return_data_on_function()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test Test #2');
        $this->assertEquals('Test Test #2', $contentHelper->getContent());
    }

    /** @test */
    public function it_returns_hrefs_simple()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test <a href="http://www.example.com" class="pb-3 bg-gray-100"> and so on');
        $result = $contentHelper->getHrefsAsArray();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('http://www.example.com', $result[0]);
    }

    /** @test */
    public function it_returns_hrefs_more()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test <a href="http://www.example.com/link#2" class="pb-3 bg-gray-100"> and </a> so <a href="someurl.php?foo=bar&bar=baz">on</a> ');
        $result = $contentHelper->getHrefsAsArray();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('http://www.example.com/link#2', $result[0]);
        $this->assertEquals('someurl.php?foo=bar&bar=baz', $result[1]);
    }

    /** @test */
    public function it_returns_hrefs_complex()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test <a href="http://max@example:www.example.com/link#2" class="pb-3 bg-gray-100"> and </a> so <a href="som.eu-r_l.php#anchor?foo=bar&bar=baz">on</a> ');
        $result = $contentHelper->getHrefsAsArray();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('http://max@example:www.example.com/link#2', $result[0]);
        $this->assertEquals('som.eu-r_l.php#anchor?foo=bar&bar=baz', $result[1]);
    }

    /** @test */
    public function it_returns_hrefs_simple_collection()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test <a href="http://www.example.com.org" class="pb-3 bg-gray-100"> and so on');
        $result = $contentHelper->getHrefs();
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(1, $result);
        $this->assertEquals('http://www.example.com.org', $result[0]);
    }
}
