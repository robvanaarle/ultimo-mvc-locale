<?php

namespace ultimo\util\locale\mvc\phptpl\helpers;

class Locale extends \ultimo\phptpl\mvc\Helper {
  
  /**
   * Helper initial function.
   * @return Locale This instance.
   */
  public function __invoke() {
    return $this;
  }
  
  /**
   * Returns the abbreviated name of the current set locale.
   * @return string The abbreviated name of the current set locale.
   */
  public function getLocale() {
    return $this->getPlugin()->getLocale();
  }
  
  /**
   * Returns the locale formatter.
   * @param string $locale The locale to get the formatter for, or null to
   * return the current formatter.
   */
  public function getFormatter($locale=null) {
    return $this->getPlugin()->getFormatter($locale);
  }
  
  /**
   * Returns the available locales as an array with abbreviated locale names.
   * @return array The available locales.
   */
  public function getAvailableLocales() {
    return $this->getPlugin()->getAvailableLocales();
  }
  
  /**
   * Returns the locale application plugin.
   * @return \ultimo\util\locale\mvc\plugins\Locale The locale application
   * plugin.
   */
  protected function getPlugin() {
    return $this->application->getPlugin('locale');
  }
  
}