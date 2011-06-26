<?php
require_once 'const/ConstantsTestSuite.php';
require_once 'provider/ProviderApiTestSuite.php';
require_once 'url/UrlApiTestSuite.php';
require_once 'video/VideoApiTestSuite.php';

class org_tubepress_api_ApiTestSuite
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite();

		$suite->addTest(org_tubepress_api_const_ConstantsTestSuite::suite());
		$suite->addTest(org_tubepress_api_provider_ProviderApiTestSuite::suite());
		$suite->addTest(org_tubepress_api_url_UrlApiTestSuite::suite());
		$suite->addTest(org_tubepress_api_video_VideoApiTestSuite::suite());

		return $suite;
	}
}