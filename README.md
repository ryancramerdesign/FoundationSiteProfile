# ProcessWire Site Profile Using Zurb Foundation 4

- This is a drop-in replacement for the default ProcessWire site profile. 

- See a demo at: http://processwire.com/foundation/ 

- It is mobile-first and fully responsive, capturing all the benefits of 
  Zurb Foundation 4.

- Ready to be expanded upon with built-in support for deeper levels
  of navigation nesting in the sidebar.

- Pagination ready with Foundation-specific pagination output, when/if 
  you want it. 

- Improved search engine, relative to the basic profile. 

- Library of Foundation-specific markup generation functions included,
  primary for generation of navigation (in _nav.php). 

- Uses ProcessWire 2.3+ prepend/append template file settings making 
  it easy to work with. 


## To Install

Start with a copy of ProcessWire 2.3 or newer, and its default site profile. 

### If starting with an uninstalled copy of ProcessWire

1. Replace the `/site-default/templates/` directory with the `templates` 
   directory from this profile. 

2. Replace the `/site-default/config.php` file with the `config.php` file 
   from this profile.

3. Run the ProcessWire installer.

### If starting with an already-installed copy of ProcessWire

1. Replace the `/site/templates/` directory with the `templates` 
   directory from this profile. 

2. Add the following two lines to your `/site/config.php` file: 

```
$config->prependTemplateFile = '_init.php';
$config->appendTemplateFile = '_main.php';
```


## Screenshots

Desktop  
<img src='https://raw.github.com/ryancramerdesign/FoundationSiteProfile/master/screenshot-desktop.jpg' />

Mobile  
<img src='https://raw.github.com/ryancramerdesign/FoundationSiteProfile/master/screenshot-mobile.jpg' />

Or see the demo at: http://processwire.com/foundation/ 

------------

Site profile developed by Ryan Cramer
http://processwire.com 

