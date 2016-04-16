<?php

include('class/crud_engine.php');

$db = new Database();

$db->connect();

// Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions

$db->select('CRUDClass','id,name',NULL,'name="Name 1"','id DESC');

$res = $db->getResult();

print_r($res);

