<?php 

/**
 * Site map template
 *
 */

function sitemapListPage($page) {

	$out = "<li><a href='{$page->url}'>{$page->title}</a> ";	

	if($page->numChildren(true)) {
		$out .= "<ul>";
		foreach($page->children as $child) $out .= sitemapListPage($child); 
		$out .= "</ul>";
	}

	$out .= "</li>";
	return $out; 
}

$body .= "<ul class='side-nav sitemap'>" . sitemapListPage($pages->get("/")) . "</ul>";

