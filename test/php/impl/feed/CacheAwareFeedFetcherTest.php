<?php

require_once dirname(__FILE__) . '/../../../../sys/classes/org/tubepress/impl/feed/CacheAwareFeedFetcher.class.php';

class org_tubepress_impl_feed_CacheAwareFeedFetcherTest extends TubePressUnitTest {

	private $_sut;

	function setUp()
	{
		parent::setUp();
		$this->_sut = new org_tubepress_impl_feed_CacheAwareFeedFetcher();
 	        org_tubepress_impl_log_Log::setEnabled(false, array());
	}

	function testFetchGoodXmlCacheHit()
	{
	    $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();

	    $cache = $ioc->get('org_tubepress_api_cache_Cache');
	    $cache->shouldReceive('get')->once()->with("http://www.ietf.org/css/ietf.css")->andReturn('someValue');

	    $this->assertEquals('someValue', $this->_sut->fetch("http://www.ietf.org/css/ietf.css", true));
	}

	function testFetchGoodXmlCacheMiss()
	{
	    $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();

	    $cache = $ioc->get('org_tubepress_api_cache_Cache');
	    $cache->shouldReceive('get')->once()->with("http://www.ietf.org/css/ietf.css")->andReturn(false);
	    $cache->shouldReceive('save')->once()->with("http://www.ietf.org/css/ietf.css", "someValue");

	    $httpClient = $ioc->get('org_tubepress_api_http_HttpClient');
	    $httpClient->shouldReceive('get')->once()->with("http://www.ietf.org/css/ietf.css")->andReturn('someValue');

	    $this->assertEquals('someValue', $this->_sut->fetch("http://www.ietf.org/css/ietf.css", true));
	}

	function testFetchGoodXmlCacheDisabled()
	{
	    $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();

	    $httpClient = $ioc->get('org_tubepress_api_http_HttpClient');
	    $httpClient->shouldReceive('get')->once()->with("http://www.ietf.org/css/ietf.css")->andReturn('someValue');

		$this->assertEquals('someValue', $this->_sut->fetch("http://www.ietf.org/css/ietf.css", false));
	}

	/**
     * @expectedException Exception
     */
	function getExpectedNetworkOutput($url)
	{
		$ch = curl_init($url);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
	}
}
