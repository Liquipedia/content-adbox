<?php

if(!isset($wgTLWiki)) {
	$wgTLWiki = '';
}

switch ($wgTLWiki)
{
case 'sc':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_BW_BTF1 -->
<div id='div-gpt-ad-1450471156048-19'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-19'); });
</script>
</div>
END_HTML;
	break;
case 'sc2':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_SC2_BTF1 -->
<div id='div-gpt-ad-1450471156048-33'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-33'); });
</script>
</div>
END_HTML;
	break;
case 'dota2':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_Dota2_BTF1 -->
<div id='div-gpt-ad-1450471156048-23'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-23'); });
</script>
</div>
END_HTML;
	break;
case 'heroes':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_Hearth_BTF1 -->
<div id='div-gpt-ad-1450471156048-25'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-25'); });
</script>
</div>
END_HTML;
	break;
case 'hearthstone':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_Hearth_BTF1 -->
<div id='div-gpt-ad-1450471156048-25'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-25'); });
</script>
</div>
END_HTML;
	break;
case 'counterstrike':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_CS_BTF1 -->
<div id='div-gpt-ad-1450471156048-21'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-21'); });
</script>
</div>
END_HTML;
	break;
case 'overwatch':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_Overwatch_BTF1 -->
<div id='div-gpt-ad-1450471156048-31'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-31'); });
</script>
</div>
END_HTML;
	break;
case 'smash':
	$btf_ad_code = <<<END_HTML
<!-- /23616703/Liquipedia_728x90_Smash_BTF1 -->
<div id='div-gpt-ad-1450471156048-35'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1450471156048-35'); });
</script>
</div>
END_HTML;
	break;
}

class ContentAdboxHooks {
	public static function onParserBeforeStrip( &$parser, &$text, &$mStripState ) {
		global $btf_ad_code;
		$adbox_code = "\n<div style=\"background-color: #444; color: #fff; height:110px; width:100%;\">$btf_ad_code</div>\n";
		
		$title = $parser->getTitle();
		if($title->getNamespace() != NS_MAIN) {
			return true;
		}
		$article = WikiPage::factory($title);
		if ($article->getText(Revision::FOR_PUBLIC) != $text)
			return;
		$has_added_adbox = false;
		if (preg_match_all("/\n\s*==([^=]+)==\s*\n/", "\n" . $text, $findings)) {
			$number_of_adboxes = 1;
			$configtitle = Title::newFromText('Adbox_Headings', NS_MEDIAWIKI);
			$config = WikiPage::factory($configtitle);
			$pages = $config->getText(Revision::FOR_PUBLIC);
			$key_headings = explode("\n", $pages);
			foreach($key_headings as $key_heading) {
				foreach($findings[1] as $findingid => $finding) {
					if(!$has_added_adbox) {
						$pos = strpos($text, $findings[0][$findingid]);
						if (trim($finding) == $key_heading) {
							$text = substr_replace($text, $findings[0][$findingid] . $adbox_code, $pos, strlen($findings[0][$findingid]));
							$has_added_adbox = true;
							break 2;
						}
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
}

?>