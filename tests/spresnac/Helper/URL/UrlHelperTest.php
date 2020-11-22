<?php

namespace spresnac\tests\Helper\URL;

use PHPUnit\Framework\TestCase;
use spresnac\Helper\URL\UrlHelper;

class UrlHelperTest extends TestCase
{
    /** @test */
    public function it_does_nothing_on_normal_url()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://example.com/some/test/url.html';
        $result = $url_helper->normalize_url($test_url);
        $this->assertEquals($test_url, $result);
    }

    /** @test */
    public function it_normalizes_a_url_with_two_dots()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://example.com/some/../url.html';
        $result = $url_helper->normalize_url($test_url);
        $this->assertEquals('https://example.com/url.html', $result);
    }

    /** @test */
    public function it_normalizes_a_url_with_two_dots_2()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://example.com/some/../strange/url/../dir/url.html';
        $result = $url_helper->normalize_url($test_url);
        $this->assertEquals('https://example.com/strange/dir/url.html', $result);
    }

    /** @test */
    public function it_normalizes_a_url_with_two_times_two_dots_direct_following()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://example.com/some/strange/url/../../dir/url.html';
        $result = $url_helper->normalize_url($test_url);
        $this->assertEquals('https://example.com/some/dir/url.html', $result);
    }
}
