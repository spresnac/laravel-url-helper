<?php

namespace spresnac\tests\Helper\URL;

use PHPUnit\Framework\TestCase;
use spresnac\Helper\URL\UrlHelper;

class UrlHelper_getSubDomainPartTest extends TestCase
{
    /** @test */
    public function it_works_normal()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://www.example.com';
        $result = $url_helper->getSubdomainPart($test_url);
        $this->assertEquals('www', $result);
    }

    /** @test */
    public function it_works_with_more_than_just_domain_part()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://www.example.com/foo/bar/fish.html';
        $result = $url_helper->getSubdomainPart($test_url);
        $this->assertEquals('www', $result);
    }

    /** @test */
    public function it_works_returns_an_empty_string_when_entring_non_domain_informations()
    {
        $url_helper = new UrlHelper();
        $test_url = 'this is not a domain';
        $result = $url_helper->getSubdomainPart($test_url);
        $this->assertEquals('', $result);
    }

    /** @test */
    public function it_works_returns_an_empty_string_when_entring_an_empty_string()
    {
        $url_helper = new UrlHelper();
        $test_url = '';
        $result = $url_helper->getSubdomainPart($test_url);
        $this->assertEquals('', $result);
    }

    /** @test */
    public function it_works_with_subdomains_containing_multiple_dotparts()
    {
        $url_helper = new UrlHelper();
        $test_url = 'https://www.mail.mail2.example.com';
        $result = $url_helper->getSubdomainPart($test_url);
        $this->assertEquals('www.mail.mail2', $result);
    }
}
