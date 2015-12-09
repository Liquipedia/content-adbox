<?php

$wgExtensionCredits['parserhook'][] = array(
								'name' => 'ContentAdbox',
								'author' =>'Alex Winkler',
								'url' => '',
								'description' => 'Allows to put ads in the content.',
								'descriptionmsg' => "Allows to put ads in the content. The headings can be defined in [[MediaWiki:Adbox_Headings]]",
								'version' => '1.0',
								'path' => __FILE__,
);

$wgHooks['ParserBeforeStrip'][] = 'fnContentAdbox';

function fnContentAdbox( &$parser, &$text, &$mStripState ) {
	$title = $parser->getTitle();
	$article = new Article($title);
	if ($article->getContent() != $text) {
		return;
	}
	
	preg_match_all("/\n\s*==([^=]+)==\s*\n/", "\n" . $text, $findings);
	$has_added_adbox = false;
	$number_of_adboxes = 1;
	$configtitle = Title::newFromText('Adbox_Headings', NS_MEDIAWIKI);
	$config = new Article($configtitle);
	$pages = $config->getContent();
	$key_headings = explode("\n", $pages);
	$adbox_code = "\n<div style=\"background-color: #444; color: #fff; height:110px; width:100%;\">Adcode here</div>\n";
	
	foreach($key_headings as $key_heading) {
		foreach($findings[1] as $findingid => $finding) {
			if(!$has_added_adbox) {
				$pos = strpos($text, $findings[0][$findingid]);
				if (trim($finding) == $key_heading) {
					$text = substr_replace($text, $findings[0][$findingid] . $adbox_code, $pos, strlen($findings[0][$findingid]));
					$has_added_adbox = true;
				}
			}
		}
	}
	if(!$has_added_adbox) {
		if (count($findings[0]) <= 2) {
			$text = $text . $adbox_code;
		} else {
			$pos = strpos($text, $findings[0][ceil((count($findings[0]) - 1) / 2)]);
			$text = substr_replace($text, $findings[0][ceil((count($findings[0]) - 1) / 2)] . $adbox_code, $pos, strlen($findings[0][ceil((count($findings[0]) - 1) / 2)]));
			$has_added_adbox = true;
		}
	}
	return true;
}


?>