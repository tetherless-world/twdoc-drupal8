<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('common/TWDocs.inc');

/**
 * Defines a logger object for TW Sparql module to provide feedback to
 * users specific to Drupal.
 * @author pattoe 
 * @author pwest
 */
class DrupalTWDocsLogger implements TWDocsLogger {
  protected $config;

  public static function init() {
    TWDocs::$logger = new DrupalTWDocsLogger();
  }
  
  public function __construct() {
    $this->config = \Drupal::config('twdocs.settings');
  }
  
  /**
   * Return whether debugging is turned on or not
   */
  public function shouldDebug() {
    return $this->config->get('enable_debug', FALSE) ;
  }

  /**
   * Set whether or not we should debug
   */
  public function enableDebug($val) {
  }

  /**
   * Logs a string as an error.
   * @param string $str String to log to the error console. 
   */
  public function logError($str) {
    if( $this->shouldDebug() ) {
      \Drupal::logger('twdocs')->error($str);
    }
  }
  
  /**
   * Logs a string as a warning
   * @param string $str String to log to the warning console. 
   */
  public function logWarning($str) {
    if( $this->shouldDebug() ) {
      \Drupal::logger('twdocs')->warning($str);
    }
  }
  
  /**
   * Logs a string as a status
   * @param string $str String to log to the status console. 
   */
  public function logStatus($str) {
    if( $this->shouldDebug() ) {
      \Drupal::logger('twdocs')->info($str);
    }
  }
}

class DrupalTWDocs extends TWDocs {
  /**
   * Object with configuration for geshifilter.
   *
   * @var object
   */
  protected $config;

  public static function init() {
    TWDocs::$engine = new DrupalTWDocs();
  }

  public function __construct() {
    $this->config = \Drupal::config('twdocs.settings');
  }
  
  public function shouldDebug() {
    return TWDocs::getLogger()->shouldDebug() ;
  }
  
  public function enableDebug($val) {
    TWDocs::getLogger()->enableDebug($val) ;
  }
  
  public function getBaseURI() {
    return $this->config->get('baseuri', 'http://tw.rpi.edu/media');
  }

  public function setBaseURI($val) {
  }
  
  public function getServiceID() {
    return $this->config->get('serviceid', 'tw.rpi.edu');
  }

  public function setServiceID($val) {
  }

  public function getApiKey() {
    return $this->config->get('apikey', 'XXXX');
  }

  public function setApiKey($val) {
  }

  public function getDefaultDocPage() {
    return $this->config->get('defaultdocpage', 'https://tw.rpi.edu/web/doc/Document');
  }

  public function setDefaultDocPage($val) {
  }
}

// Could have just used the DrupalTWDocs static function init to
// initialize all three of these, but could be the case where someone
// wants to use different loggers and caching mechanisms instead of the
// Drupal one here.
DrupalTWDocs::init();
DrupalTWDocsLogger::init();

