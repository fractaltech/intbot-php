<?php

namespace Flowapp\Intbot;

class Flow {
  protected $token;
  protected $statuses;
  protected $steps;
  protected $fields;

  public function __construct($token, $statuses, $steps, $fields) {
    $this->token = $token;
    $this->statuses = $statuses;
    $this->steps = $steps;
    $this->fields = $fields;
  }

  public function field($title) {
    foreach ($this->fields as $field) {
      if ($field->title === $title) {
        return $field;
      }
    }

    return null;
  }

  public function status($name) {
    foreach ($this->statuses as $status) {
      if ($status->name === $name) {
        return $status;
      }
    }

    return null;
  }

  public function step($fromStatusName, $toStatusName) {
    foreach ($this->steps as $step) {
      if ($step->from_status->name === $fromStatusName && $step->to_status->name === $toStatusName) {
        return $step;
      }
    }

    return null;
  }

  public function getRecords($params) {
    return Client::getRecords($this->token, $params);
  }

  public function uploadRecords($step, $records) {
    return Client::uploadRecords($this->token, $step, $records);
  }

  public function updateRecord($record, $data) {
    return Client::updateRecord($this->token, $record, $data);
  }

  public function deleteRecords($records) {
    return Client::deleteRecords($this->token, $records);
  }

  public function moveRecords($step, $records) {
    return Client::moveRecords($this->token, $step, $records);
  }

  public function delegateRecords($user, $records) {
    return Client::delegateRecords($this->token, $user, $records);
  }
}
