<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements_Model extends TreeTrailModel {

  public $tableName = 'announcements';
  public $tableId   = 'id';
  public $tableTitle   = 'title';
  public $tableDate   = 'date';
  public $tableBody = 'body';
  public $tableUser   = 'user';
}