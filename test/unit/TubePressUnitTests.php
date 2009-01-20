<?php

require_once '/Applications/MAMP/bin/php5/lib/php/PHPUnit/Framework.php';
require_once dirname(__FILE__) . "/../../common/tubepress_classloader.php";

$testNames = array(
	"org_tubepress_cache_SimpleCacheService",
	"SimpleTubePressFeedInspectionService",
	"SimpleTubePressOptionsManager",
	"SimpleTubePressQueryStringService",
	"SimpleTubePressShortcodeService",
	"SimpleTubePressThumbnailService",
	"org_tubepress_url_SimpleUrlBuilder",
	"SimpleTubePressInputValidationService",
	"SimpleTubePressVideoFactory",
	"org_tubepress_player_impl_GreyBoxPlayer",
	"org_tubepress_player_impl_LightWindowPlayer",
	"org_tubepress_player_impl_NormalPlayer",
	"org_tubepress_player_impl_ShadowBoxPlayer",
	"org_tubepress_player_impl_YouTubePlayer",
	"TubePressAdvancedOptions",
	"TubePressDisplayOptions",
	"TubePressEmbeddedOptions",
	"SimpleTubePressEmbeddedPlayerService",
	"TubePressFeedRetrievalService_HTTP_Request2",
	"TubePressGalleryOptions",
	"org_tubepress_gallery_Gallery",
	"TubePressMetaOptions",
	"TubePressOptionsForm",
	"org_tubepress_pagination_DiggStylePaginationService",
	"TubePressStringUtils",
	"TubePressVideo",
	"org_tubepress_gallery_WidgetGallery",
	"TubePressWidgetOptions",
	"WordPressStorageManager"
);

foreach ($testNames as $test) {
	require_once "tests/" . $test . "Test.php";
}

function __($key) {
	return $key;
}

class TubePressUnitTests
{
	public static function suite()
	{
		global $testNames;
		$suite = new PHPUnit_Framework_TestSuite("TubePress Unit Tests");
		foreach ($testNames as $test) {
			$suite->addTestSuite($test . "Test");
		}
		return $suite;
	}
}

?>
