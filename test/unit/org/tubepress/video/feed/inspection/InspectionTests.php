<?php
require dirname(__FILE__) . '/../../../../../PhpUnitLoader.php';
require_once 'YouTubeFeedInspectionServiceTest.php';

class InspectionTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite("TubePress Video Feed Inspection Tests");
		$suite->addTestSuite('org_tubepress_video_feed_inspection_YouTubeFeedInspectionServiceTest');
		return $suite;
	}
}
?>
