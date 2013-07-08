# ProcessWire Site Profile Using Zurb Foundation 4

This is a drop-in replacement for the default ProcessWire site profile. 
As a result, it consists only of a `/site/templates/` directory and 
nothing more. 

## To Install

Start with a copy of ProcessWire 2.3 or newer, and its default site profile. 

### If starting with an uninstalled copy of ProcessWire

1. Replace the `/site-default/templates/` directory with the `templates` 
   directory from this profile. 

2. Replace the `/site-default/config.php` file with the `config.php` file 
   from this profile.

3. Run the ProcessWire installer.

### If starting with an already-installed copy of ProcessWire

1. Replace the `/site-default/templates/` directory with the `templates` 
   directory from this profile. 

2. Add the following two lines to your `/site/config.php` file: 

```
$config->prependTemplateFile = '_init.php';
$config->appendTemplateFile = '_main.php';
```

------------

Site profile developed by Ryan Cramer
http://processwire.com 

