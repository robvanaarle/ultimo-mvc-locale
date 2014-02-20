<?php

namespace ultimo\util\locale\mvc\plugins;

class Locale implements \ultimo\mvc\plugins\ApplicationPlugin {
  
  /**
   * The current set locale.
   * @var string
   */
  protected $locale;
  
  /**
   * The fallback locale used when the desired locale is not available.
   * @var string
   */
  protected $fallbackLocale;
  
  /**
   * The current set formatter.
   * @var \ultimo\util\locale\LocaleFormatter
   */
  protected $formatter;
  
  /**
   * The session to store the persistent locale in.
   * @var \ultimo\util\net\Session
   */
  protected $session;

  /**
   * Constructor.
   * @param string $fallbackLocale The locale to use when no persistent or
   * volatile locale set.
   */
  public function __construct($fallbackLocale='en') {
    $this->setFallbackLocale($fallbackLocale);
    
    $this->session = new \ultimo\util\net\Session('ultimo.util.locale.mvc.plugins.Locale');
    if (isset($this->session->locale)) {
      $this->setLocale($this->session->locale);
    } else {
      $this->setLocale(null);
    }
  }
  
  /**
   * Returns the available locales as an array with abbreviated locale names.
   * @return array The available locales.
   */
  public function getAvailableLocales() {
    return \ultimo\util\locale\FormatterFactory::getAvailableLocales();
  }
  
  /**
   * Sets the fallback locale.
   * @param string $locale The locale to set as fallback.
   */
  public function setFallbackLocale($locale) {
    $this->fallbackLocale = $locale; 
  }
  
  /**
   * Returns the fallback locale.
   * @return string The fallback locale.
   */
  public function getFallbackLocale() {
    return $this->fallbackLocale;
  }
  
  /**
   * Sets the current locale.
   * @param string $locale The current locale to set, or null to unset the
   * locale. The fallback locale will then be used.
   * @param boolean $persistent Whether to use the locale between requests.
   */
  public function setLocale($locale, $persistent=false) {
    $this->locale = $locale;
    if ($persistent) {
      $this->session->locale = $locale;
      $this->session->flush();
    }
    
    if ($locale === null) {
      $locale = $this->fallbackLocale;
    }
    
    $this->formatter = \ultimo\util\locale\FormatterFactory::getFormatter(new \ultimo\util\locale\Locale($locale));
    if ($this->formatter === null) {
      $this->formatter = \ultimo\util\locale\FormatterFactory::getFormatter(new \ultimo\util\locale\Locale($this->fallbackLocale));
    }
  }
  
  /**
   * Returns the current locale, or null if no locale is set.
   * @return string The current locale.
   */
  public function getLocale() {
    return $this->locale;
  }
  
  /**
   * Returns the formatter for the current or another locale.
   * @param string $locale The locale to get the formatter for, or null to get
   * the current formatter.
   * @return \ultimo\util\locale\Formatter The formatter for the specified
   * locale, or null if no formatter exists for the specified locale.
   */
  public function getFormatter($locale=null) {
    if ($locale === null) {
      
      return $this->formatter;
    } else {
      if (is_string($locale)) {
        $locale = new \ultimo\util\locale\Locale($locale);
      }
      return \ultimo\util\locale\FormatterFactory::getFormatter($locale);
    }
  }
  
  /**
   * Returns whether a locale is available.
   * @param string $locale The locale to check the availability for.
   * @return boolean Whether the locale is available.
   */
  public function isAvailable($locale) {
    return in_array($locale, $this->locales);
  }
  
  public function onPluginAdded(\ultimo\mvc\Application $application) { }
  
  /**
   * Adds the Locale view helper.
   */
  public function onModuleCreated(\ultimo\mvc\Module $module) {
    $view = $module->getView();
    
    // add the view helpers directory, if the view is phptpl
    if ($view instanceof \ultimo\phptpl\Engine) {
      $helperPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'phptpl' . DIRECTORY_SEPARATOR . 'helpers';
      
      $nsElems = explode('\\', __NAMESPACE__);
      array_pop($nsElems);
      array_push($nsElems, 'phptpl', 'helpers');
      $helperNamespace = '\\' . implode('\\', $nsElems);
      $view->addHelperPath($helperPath, $helperNamespace);
    }
  }
  
  public function onRoute(\ultimo\mvc\Application $application, \ultimo\mvc\Request $request) { }
  
  public function onRouted(\ultimo\mvc\Application $application, \ultimo\mvc\Request $request=null) { }
  
  public function onDispatch(\ultimo\mvc\Application $application) { }
  
  public function onDispatched(\ultimo\mvc\Application $application) { }
  
}