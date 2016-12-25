<?php

namespace Flowapp\Intbot;

use GuzzleHttp;

class Intbot {
  protected static $flows = [];

  public static function load() {
    $flowTokens = func_get_args();

    foreach ($flowTokens as $token) {
      $process = Client::getFlowProcess($token);
      $fields = Client::getFields($token);

      static::$_flows[$token] = new Flow($token, $process['statuses'], $process['steps'], $fields);
    }
  }

  public static function unload() {
    $flowTokens = func_get_args();

    foreach ($flowTokens as $token) {
      unset(static::$_flows[$token]);
    }
  }

  public static function flow($token) {
    if (!isset(static::$_flows[$token])) {
      throw new Exception('invalid token: `'.$token.'`');
    }

    return satic::$_flows[$token];
  }
}
