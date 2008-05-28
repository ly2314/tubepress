<?php
/**
 * Copyright 2006, 2007, 2008 Eric D. Hough (http://ehough.com)
 * 
 * This file is part of TubePress (http://tubepress.org)
 * 
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Options that control which meta info is displayed below video
 * thumbnails
 *
 */
class TubePressMetaOptions
{   
    const AUTHOR 		= "author";
	const CATEGORY 		= "category";
	const DESCRIPTION 	= "description";
	const ID 			= "id";
	const LENGTH 		= "length";
	const RATING 		= "rating";
	const RATINGS 		= "ratings";
	const TAGS 			= "tags";
	const TITLE 		= "title";
	const UPLOADED 		= "uploaded";
	const URL 			= "url";
	const VIEWS 		= "views";
	
	public function printForOptionsForm(HTML_Template_IT &$tpl, TubePressStorageManager $tpsm)
    {

    	$title = "meta";
    	
        $tpl->setVariable("OPTION_CATEGORY_TITLE",
        	TpMsg::_("options-category-title-" . $title));

        $class = new ReflectionClass("TubePressMetaOptions");	

        $colCount = 0;
        
        /* go through each option in the category */
        foreach($class->getConstants() as $constant) {
        	$tpl->setVariable("EXTRA_STYLE", "; width: 15em");
            $tpl->setVariable("OPTION_TITLE", TpMsg::_(sprintf("options-%s-title-%s", $title, $constant)));
            $tpl->setVariable("OPTION_DESC", TpMsg::_(sprintf("options-%s-desc-%s", $title, $constant)));
            $tpl->setVariable("OPTION_NAME", $constant);
        
            TubePressOptionsForm::displayBooleanInput($tpl, $constant, $tpsm->get($constant));
            
            if (++$colCount % 5 === 0) {
                $tpl->parse("optionRow");
            } else {
                $tpl->parse("option");
            }
        }
        $tpl->parse("optionCategory");
    }
}
              