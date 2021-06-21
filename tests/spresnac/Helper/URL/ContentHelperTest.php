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

    /** @test */
    public function it_returns_links_in_plain_text()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test http://www.example.com.org and so on
so let\'s test some https://more.com#example
and maybe some inline /config/something.php
maybe also a ftp link ftp://somewhere?and&this=1');
        $result = $contentHelper->getLinksFromPlaintext();
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(3, $result);
        $this->assertEquals('http://www.example.com.org', $result[0]);
        $this->assertEquals('https://more.com#example', $result[1]);
        $this->assertEquals('ftp://somewhere?and&this=1', $result[2]);
    }

    /** @test */
    public function it_gets_all_the_links_from_a_document()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('Test <a href="http://www.example.com.org" class="pb-3 bg-gray-100"> and so <img src="/img/anything.png" /> on');
        $result = $contentHelper->getAllTheLinks();
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(2, $result);
        $this->assertEquals('http://www.example.com.org', $result[0]);
        $this->assertEquals('/img/anything.png', $result[1]);
    }

    /** @test */
    public function it_gets_all_links_correct_in_plaintext()
    {
        $contentHelper = new ContentHelper();
        $contentHelper->setContent('<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url><loc>https://example.com/impressum/</loc><lastmod>2021-06-15</lastmod><changefreq>daily</changefreq><priority>0.5</priority></url><url><loc>https://example.com/datenschutz/</loc><lastmod>2021-06-15</lastmod><changefreq>daily</changefreq><priority>0.5</priority></url><url><loc>https://example.com/</loc><lastmod>2021-06-18</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url></urlset>
');
        $result = $contentHelper->getLinksFromPlaintext();
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(4, $result);
        $this->assertEquals('http://www.sitemaps.org/schemas/sitemap/0.9', $result[0]);
        $this->assertEquals('https://example.com/impressum/', $result[1]);
        $this->assertEquals('https://example.com/datenschutz/', $result[2]);
        $this->assertEquals('https://example.com/', $result[3]);
    }
}
