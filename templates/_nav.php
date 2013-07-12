<?php

/**
 * _nav.php - Navigation/markup generating helper functions
 * 
 * This file contains various "render" functions that generate navigation markup 
 * specific to the Foundation site profile. 
 *
 * What's Here:
 * 
 * renderNav(PageArray $items, [$options]) - Render a generic navigation list
 * renderSubNav(Page $page) - Render Foundation 'side-nav' list for given $page
 * renderBodyNav(PageArray $items) - Render Foundation 'side-nav' for bodycopy placement
 * renderBreadcrumbs(PageArray $items) - Render Foundation 'breadcrumbs' list
 * renderPagination(PageArray $items) - Render pagination links using Foundation classes
 * renderTopBar(PageArray $items, [array $options]) - Render Foundation 'top-bar' navigation
 * renderOrbit($images, [$width], [$height]) - Render a Foundation 'orbit' slideshow
 *
 */

/**
 * Render a <ul> navigation list 
 *
 */
function renderNav(PageArray $items, array $options = array()) {

	if(!count($items)) return '';

	$defaults = array(
		'fields' => array(), // array of other fields you want to display (title is assumed)
		'class' => '', // class for the <ul>
		'active' => 'active', // class for active item
		'dividers' => false, // add an <li class='divider'> between each item?
		'tree' => false, // render tree to reach current $page?
		);

	$options = array_merge($defaults, $options); 
	$page = wire('page');
	$out = "<ul class='$options[class]'>";
	$divider = $options['dividers'] ? "<li class='divider'></li>" : "";

	foreach($items as $item) {

		// if this item is the current page, give it an 'active' class
		$class = $item->id == $page->id ? " class='$options[active]'" : "";

		// render linked item title
		$out .= "$divider<li$class><a href='$item->url'>$item->title</a> "; 

		// render optional extra fields wrapped in named spans
		if(count($options['fields'])) foreach($options['fields'] as $name) {
			$out .= "<span class='$name'>" . $item->get($name) . "</span> ";
		}

		// optionally render a tree recursively to current $page 
		if($options['tree']) {
			if($page->parents->has($item) || $item->id == $page->id) {
				$out .= renderNav($item->children("limit=50"), array(
					'fields' => $options['fields'],
					'tree' => true,
					)); 
			}
		}

		$out .= "</li>";
	}

	$out .= "</ul>";
	return $out; 	
}

/**
 * Render a Foundation 'side-nav' list for placement in #sidebar
 *
 */
function renderSubNav(Page $page) {

	if(!$page->numChildren(true)) return '';

	$options = array(
		'class' => 'side-nav',
		'dividers' => true,
		'tree' => true,
		);	

	$out = "<h3><a href='$page->url'>$page->title</a></h3>"; 
	$out .= renderNav($page->children, $options); 

	return $out; 
}

/**
 * Render a Foundation 'side-nav' list intended for placment in #bodycopy
 *
 * If $items had a limit placed on it, this will append pagination links
 *
 */
function renderBodyNav(PageArray $items, array $options = array()) {
	$defaults = array(
		'class' => 'body-nav side-nav',
		'fields' => array('summary'),
		'dividers' => true
		);	
	$options = array_merge($defaults, $options); 
	return renderNav($items, $options) . renderPagination($items); 
}

/**
 * Render breadcrumb navigation
 *
 */
function renderBreadcrumbs(PageArray $items) {

	// if the page has a headline that's different from the title, add it to the bredcrumbs
	$page = wire('page');
	if($page->headline) $items->add($page); 

	$options = array(
		'class' => 'breadcrumbs',
		'active' => 'unavailable',
		);

	return renderNav($items, $options); 
}

/**
 * Render pagination links
 *
 * This uses ProcessWire's MarkupPagerNav module and overrides the default
 * markup to focus on Foundation-specific pagination styles.
 *
 */
function renderPagination(PageArray $items) {

	if(!$items->getLimit() || $items->getTotal() <= $items->getLimit()) return '';
	$page = wire('page'); 

	if(!$page->template->allowPageNum) {
		// notify developer they need to enable pagination in the template
		return 	"<p class='alert label'>" . 
			"This template needs page numbers enabled to support pagination!<br />" . 
			"Go to: Admin - Setup - Templates - Edit: '$page->template' - URLs " . 
			"</p>";
	}

	// customize the MarkupPagerNav to output in Foundation-style pagination links
	$options = array(
		'nextItemLabel' => '&raquo;',
		'nextItemClass' => 'arrow',
		'previousItemLabel' => '&laquo;',
		'previousItemClass' => 'arrow',
		'lastItemClass' => 'last',
		'currentItemClass' => 'current',
		'separatorItemLabel' => '&hellip;',
		'separatorItemClass' => 'unavailable',
		'listMarkup' => "<ul class='pagination'>{out}</ul>", 
		'itemMarkup' => "<li class='{class}'>{out}</li>", 
		'linkMarkup' => "<a href='{url}'>{out}</a>"
		);

	$pager = wire('modules')->get('MarkupPagerNav');
	$pager->setBaseUrl(wire('page')->url);
	return $pager->render($items, $options);
}

/**
 * Render items for placement in Foundation 'top-bar' recursive drop-down navigation
 *
 */
function renderTopNav(PageArray $items, array $options = array(), $level = 0) {

	$defaults = array(
		'tree' => 2, // number of levels it should recurse into the tree
		'dividers' => true,
		'repeat' => true, // whether to repeat items with children as first item in their children nav
		);

	$options = array_merge($defaults, $options); 
	$divider = $options['dividers'] ? "<li class='divider'></li>" : "";
	$page = wire('page');
	$out = '';

	foreach($items as $item) {

		$numChildren = $item->numChildren(true);
		if($level+1 > $options['tree'] || $item->id == 1) $numChildren = 0;
		$class = '';
		if($numChildren) $class .= "has-dropdown ";
		if($page->id == $item->id) $class .= "current ";
		if(($item->id > 1 && $page->parents->has($item)) || $page->id == $item->id) $class .= "active ";
		if($class) $class = " class='" . trim($class) . "'";

		$out .= "$divider<li$class><a href='$item->url'>$item->title</a>";

		if($numChildren) {
			$out .= "<ul class='dropdown'>";
			if($options['repeat']) $out .= "$divider<li><a href='$item->url'>$item->title</a></li>";
			$out .= renderTopNav($item->children, $options, $level+1); 
			$out .= "</ul>";
		}
 
		$out .= "</li>";
	}

	return $out; 
}

/**
 * Given an array of images, render a Foundation 'orbit' slideshow
 *
 */
function renderOrbit($images, $width = 800, $height = 500) {

	$out = "<ul data-orbit>";

	foreach($images as $image) {
		$image = $image->size($width, $height);
		$out .= "<li><img src='$image->url' />"; 
		if($image->description) $out .= "<div class='orbit-caption'>$image->description</div>";
		$out .= "</li>";
	}

	$out .= "</ul>";

	return $out; 
}
