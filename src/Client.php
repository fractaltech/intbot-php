<?php

namespace Flowapp\Intbot;

use GuzzleHttp;

class Client {
  protected static $_instance;

  public static function instance() {
    if (static::$_instance) {
      return static::$_instance;
    }

    static::$_instance = new GuzzleHttp\Client();
    return static::instance();
  }

  protected static function makeRequest($slug, $token, $json=[]) {
    $res = static::instance()->request(
      'POST',
      'http://api.formapp.in/integration'.$slug,
      [
        'headers' => ['integration-token' => $token],
        'json' => $json
      ]
    );

    return json_decode($res->getBody());
  }

  public static function getFlowProcess($token) {
    return static::makeRequest('/process', $token);
  }

  public static function getFields($token) {
    return static::makeRequest('/fields', $token);
  }

  public static function getUsers($token) {
    return static::makeRequest('/users', $token);
  }

  public static function getRecords($token, $params=[]) {
    return static::makeRequest('/records/list', $token, $params);
  }

  public static function uploadRecords($token, $step, $records) {
    return static::makeRequest('/records/upload/'.$step->id, $token, $records);
  }

  public static function updateRecord($token, $record, $data) {
    return static::makeRequest('/records/update/'.$record->id, $token, $data);
  }

  public static function deleteRecords($token, $records) {
    return static::makeRequest('/records/delete', $token, [
      'record_ids' => array_map(function ($r) { return $r->id; }, $records)
    ]);
  }

  public static function moveRecords($token, $step, $records) {
    return static::makeRequest('/records/move/'.$step->id, $token, [
      'record_ids' => array_map(function ($r) { return $r->id; }, $records)
    ]);
  }

  public static function delegateRecords($token, $user, $records) {
    return static::makeRequest('/records/delegate-to/'.$user->id, $token, [
      'record_ids' => array_map(function ($r) { return $r->id; }, $records)
    ]);
  }
}
