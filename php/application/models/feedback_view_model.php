<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback_view_model extends TreeTrailModel {

  public $tableName = 'feedback';
  public $tableId   = 'id';
  public $tableCp   = 'name';
  public $tablemail   = 'email';
  public $tabletitle = 'title';
  public $tablebody   = 'body';
  public $tabledate   = 'date_added';
}