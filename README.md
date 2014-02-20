# Ultimo Locale MVC
Locale formatting for Ultimo MVC

Includes an helper for Phptpl to format in views.

## Requirements
* PHP 5.3
* Ultimo Locale
* Ultimo MVC
* Ultimo Phptpl
* Ultimo Session

## Usage
### Register plugin
	$localesPlugin = new \ultimo\util\locale\mvc\plugins\Locale('nl');
    $localesPlugin->getFormatter()->dateTimeZone = new DateTimeZone('Europe/Amsterdam');
    $application->addPlugin($localesPlugin, 'locale');

### Formatting in Controller
	$this->application->getPlugin('locale')->getFormatter()->formatDate($date, 'shortest');

### Formatting in View
	<?php echo $this->locale()->getFormatter()->formatDate($date, 'shortest') ?>