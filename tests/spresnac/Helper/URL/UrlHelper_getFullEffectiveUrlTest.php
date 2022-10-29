<?php

namespace spresnac\tests\Helper\URL;

use PHPUnit\Framework\TestCase;
use spresnac\Helper\URL\UrlHelper;

class UrlHelper_getFullEffectiveUrlTest extends TestCase
{
    /** @test */
    public function it_return_an_already_full_url()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://www.example.com/foo/bar.html';
        $root_url = 'https://www.example.com/';
        $result = $url_helper->getFullEffectiveUrl(
            url: $test_url,
            root_url: $root_url,
        );
        $this->assertEquals($test_url, $result);
    }

    /** @test */
    public function it_completes_the_url_with_missing_scheme()
    {
        $url_helper = new UrlHelper();
        $test_url = '//www.example.com/foo/bar.html';
        $root_url = 'https://www.example.com/';
        $result = $url_helper->getFullEffectiveUrl(
            url: $test_url,
            root_url: $root_url,
        );
        $this->assertEquals('https:'.$test_url, $result);
    }

    /** @test */
    public function it_completes_the_url_with_missing_scheme_and_missing_host_absolute()
    {
        $url_helper = new UrlHelper();
        $test_url = '/uber-mich#respond';
        $root_url = 'https://www.example.com/';
        $result = $url_helper->getFullEffectiveUrl(
            url: $test_url,
            root_url: $root_url,
        );
        $this->assertEquals('https://www.example.com'.$test_url, $result);
    }

    /** @test */
    public function it_completes_the_url_with_missing_scheme_and_missing_host_relative()
    {
        $url_helper = new UrlHelper();
        $test_url = 'uber-mich#respond';
        $root_url = 'https://www.example.com/foo/bar.html';
        $result = $url_helper->getFullEffectiveUrl(
            url: $test_url,
            root_url: $root_url,
        );
        $this->assertEquals('https://www.example.com/foo/'.$test_url, $result);
    }

    /** @test */
    public function it_completes_the_url_with_only_anchor_link()
    {
        $url_helper = new UrlHelper();
        $test_url = '#respond';
        $root_url = 'https://www.example.com/foo/bar.html';
        $result = $url_helper->getFullEffectiveUrl(
            url: $test_url,
            root_url: $root_url,
        );
        $this->assertEquals($root_url.$test_url, $result);
    }
}
