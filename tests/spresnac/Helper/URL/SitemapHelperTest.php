<?php

namespace spresnac\tests\Helper\URL;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use spresnac\Helper\URL\SitemapHelper;

class SitemapHelperTest extends TestCase
{
    /** @test */
    public function it_handles_a_sitemap_string()
    {
        $sitemap_helper = new SitemapHelper();
        $input_string = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="https://www.codemercenary.de/wp-content/plugins/google-sitemap-generator/sitemap.xsl"?><!-- sitemap-generator-url="http://www.arnebrachhold.de" sitemap-generator-version="4.1.1" -->
<!-- generated-on="13. December 2020 14:44" -->
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">	<url>
		<loc>https://www.codemercenary.de/</loc>
		<lastmod>2020-11-24T14:17:31+00:00</lastmod>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
	<url>
		<loc>https://www.codemercenary.de/sitemap.html</loc>
		<lastmod>2020-11-24T14:17:31+00:00</lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
	</url>
</urlset><!-- Request ID: 307420a7c2e7b2896e52e441fe60627f; Queries for sitemap: 3; Total queries: 27; Seconds: 0.01; Memory for sitemap: 2MB; Total memory: 20MB -->
';
        $result = $sitemap_helper->process_input_from_string($input_string);
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(2, $result);
        $this->assertEquals('https://www.codemercenary.de/', $result->shift());
        $this->assertEquals('https://www.codemercenary.de/sitemap.html', $result->shift());
    }

    /** @test */
    public function it_handles_a_sitemap_url()
    {
        $sitemap_helper = new SitemapHelper();
        $input_url = 'https://www.codemercenary.de/sitemap-misc.xml';
        $result = $sitemap_helper->process_input_from_url($input_url);
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(2, $result);
        $this->assertEquals('https://www.codemercenary.de/', $result->shift());
        $this->assertEquals('https://www.codemercenary.de/sitemap.html', $result->shift());
    }

    /** @test */
    public function it_returns_an_empty_collection_when_url_not_existing()
    {
        $sitemap_helper = new SitemapHelper();
        $input_url = 'https://www.codemercenary.de/sitemap-misc.xml2222222';
        $result = $sitemap_helper->process_input_from_url($input_url);
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(0, $result);
    }

    /** @test */
    public function it_handles_a_sitemap_url_and_follows_sitemaps()
    {
        $sitemap_helper = new SitemapHelper();
        $input_url = 'https://www.codemercenary.de/sitemap.xml';
        $result = $sitemap_helper->process_input_from_url($input_url);
        $this->assertTrue($result instanceof Collection);
        $this->assertCount(430, $result);
        $this->assertEquals('https://www.codemercenary.de/sitemap-misc.xml', $result->shift());
    }
}
