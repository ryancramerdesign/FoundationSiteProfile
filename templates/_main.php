<?php 

/**
 * This is the main markup file containing the container HTML that all pages are output in.
 *
 * The primary focus of this file is to output these variables (defined in _init.php) in the 
 * appropriate places:
 *
 * $headline - Text that goes in the primary <h1> headline
 * $browserTitle - The contents of the <title> tag
 * $body - Content that appears in the bodycopy area
 * $side - Additional content that appears in the sidebar
 *
 * Note: if a variable called $useMain is set to false, then _main.php does nothing.
 *
 */

// if any templates set $useMain to false, abort displaying this file
// an example of when you'd want to do this would be XML sitemap or AJAX page.
if(!$useMain) return;

/**********************************************************************************************/

?><!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />

	<title><?php echo $browserTitle; ?></title>

	<?php if($page->summary) echo "<meta name='description' content='$page->summary' />"; ?>

	<link rel="stylesheet" href="<?php echo $config->urls->templates; ?>foundation/css/foundation.css" />
	<link rel="stylesheet" href="<?php echo $config->urls->templates; ?>styles/main.css" />

	<script src="<?php echo $config->urls->templates; ?>foundation/js/vendor/custom.modernizr.js"></script>
</head>
<body class='<?php echo "template-$page->template section-{$page->rootParent->name} page-$page"; ?>'>

	<div id='topnav'>
		<div class='contain-to-grid'>
			<nav class="top-bar">
				<ul class="title-area">
					<li class="name">
						<!--substitute in your own logo or text here-->
						<h1>
							<a href="<?php echo $config->urls->root; ?>">
								<img id='logo' src='<?php echo $config->urls->templates; ?>styles/images/logo.png' width='159' height='28' alt='ProcessWire' />
							</a>
						</h1>
					</li>
					<li class="toggle-topbar menu-icon">
						<a href="#"><span>menu</span></a>
					</li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">

						<?php echo renderTopNav($homepage->children->prepend($homepage)); ?>

						<?php if($page->editable()): ?>
						<li class='divider'></li>
						<li class='has-form'>
							<a class='tiny success button' href='<?php echo $config->urls->admin . "page/edit/?id=$page->id"; ?>'>Edit</a>
						</li>
						<?php endif; ?>

						<li class='divider show-for-small'></li>
						<li class='search has-form show-for-small'>
							<!-- this search form only displays at mobile resolution -->
							<form id='search-form-mobile' action='<?php echo $config->urls->root?>search/' method='get'>
								<input type="search" name="q" value="<?php echo $sanitizer->entities($input->whitelist('q')); ?>" placeholder="Search" />
							</form>
						</li>
					</ul>
				</section>
			</nav>
		</div>
	</div><!--/#topnav-->

	<div id="masthead" class="row">

		<div class="large-4 columns push-8">
			<!-- this search form only displays at NON-mobile resolution -->
			<form id='search-form' action='<?php echo $config->urls->root?>search/' method='get' class='hide-for-small'>
				<div class="row collapse">
					<div class="small-9 columns">
						<input type="text" name="q" value="<?php echo $sanitizer->entities($input->whitelist('q')); ?>" placeholder="" />
					</div>
					<div class="small-3 columns">
						<button type='submit' class="button prefix">Search</button>
					</div>
				</div>
			</form>
		</div>

		<div class="large-8 columns pull-4">
			<h1><?php echo $headline; ?></h1>
		</div>
	</div>

	<hr />

	<div id="content" class="row">

		<div id="bodycopy" class="large-8 columns" role="content">

			<?php 

			echo renderBreadcrumbs($page->parents); 
			echo $body; 

			?>

		</div><!--/#bodycopy-->

		<aside id="sidebar" class="large-4 columns">

			<?php 

			// Grab a random image from the homepage and display it.
			if(count($homepage->images)) {
				$image = $homepage->images->getRandom();
				$thumb = $image->size(606, 372); 
				echo "<p><img src='$thumb->url' alt='$thumb->description' /></p>";
			}

			// display sidebar navigation, except on homepage
			if($page->id > 1) echo renderSubnav($page->rootParent); 

			// if no $side content was set by the template, display the homepage's sidebar text
			if(!$side) $side = $homepage->sidebar; 
			echo "<div class='panel'>$side</div>"; 

			?>

		</aside><!--/#sidebar-->

	</div><!--/#content-->

	<hr />

	<footer>
		<div class="row">
			<div class="large-8 columns">
				<ul class='breadcrumbs'>
					<li class='unavailable'>&copy; <?php echo date('Y'); ?></li>
					<li><a href='http://processwire.com'>ProcessWire CMS</a></li>
					<li><a href='http://foundation.zurb.com'>Zurb Foundation</a></li>
				</ul>
			</div>
			<div class="large-4 columns">
			</div>
		</div>
	</footer>

	<script>document.write('<script src=<?php echo $config->urls->templates; ?>foundation/js/vendor/' + ('__proto__' in {} ? 'zepto' : 'jquery') + '.js><\/script>')</script>
	<script src="<?php echo $config->urls->templates; ?>foundation/js/foundation.min.js"></script>
	<script src="<?php echo $config->urls->templates; ?>scripts/main.js"></script>
	<script>$(document).foundation();</script>
</body>
</html>
