<?php

$subheader = "Please enter a search";

if($q = $sanitizer->selectorValue($input->get->q)) {

	// Send our sanitized query 'q' variable to the whitelist where it will be
	// picked up and echoed in the search box by (in _main.php)
	$input->whitelist('q', $q); 

	// limit=the max number of items to show per pagination
	// to use this, enable pagination on your search template (in template settings)
	$limit = 10; 

	// first try a fulltext match of keywords anywhere in title/body
	$matches = $pages->find("title|body~=$q, limit=$limit"); 

	// if the above doesn't find anything (perhaps due to MySQL minimum word 
	// length or stopwords), switch to non-indexed phrase match
	if(!count($matches)) $matches = $pages->find("title|body%=$q, limit=$limit"); 

	$total = $matches->getTotal();
	$start = $matches->getStart()+1;
	$end = $matches->getStart() + count($matches); 
	
	if($total) {

		foreach($matches as $item) {
			// if item has no summary, substitute something else
			if(!$item->summary) $item->summary = "Found in: $item->path"; 
		}

		$subheader = "Matches $start to $end of $total:"; 
		$body .= renderBodyNav($matches); 

	} else {
		$subheader = "Sorry, no results were found.";
	}
}

$body = "<h2 class='subheader'>$subheader</h2>$body";

