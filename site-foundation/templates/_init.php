<?php

/**
 * _init.php - Initialize site variables and includes. 
 *
 * This file is called before any template files are rendered
 * This behavior was defined in /site/config.php - $config->prependTemplateFile
 *
 */

/*
 * Initialize some variables used by templates and populate default values.
 * These variables will ultimately be output in the _main.php file. 
 * The individual template files may choose to overwrite any of these. 
 *
 */
$browserTitle = $page->get('browser_title|title');
$headline = $page->get('headline|title');
$body = $page->body; 
$side = $page->sidebar;

/**
 * Add custom classes to some elements inserted from the rich text editor
 * so that we can identify and style them separately from others.
 * 
 * In our case, we want to add a 'subheader' class to <h2> tags, and we want 
 * to add an 'in' class to <ul> and <ol> elements so that we can style them 
 * separately from other <ul> or <ol> tags that Foundation might use for 
 * navigation and such. This is all optional of course. 
 *
 */
$body = str_replace(
	// find these:
	array('<h2>', '<ul>', '<ol>'),
	// and replace with these:
	array('<h2 class="subheader">', '<ul class="in">', '<ol class="in">'),
	// in the $body text
	$body); 

/*
 * Whether to include the _main.php markup file? For example, your template 
 * file would set it to false when generating a page for sitemap.xml 
 * or ajax output, in order to prevent display of the main <html> document.
 *
 */
$useMain = true; 

/*
 * Make a pre-fetched copy of the homepage available to all our templates
 * this is worthwhile since we use it so often, helps readability, etc.
 * 
 */
$homepage = $pages->get('/'); 

/*
 * Include any other shared functions we want to utilize in all our templates
 *
 */
require_once("./_nav.php"); 

