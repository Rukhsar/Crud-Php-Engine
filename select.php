<?php

include('class/crud_engine.php');

$db = new CrudEngine();

$db->connect();

// Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions

$db->select('CRUD','id,name',NULL,'name="Name 1"','id DESC');

$res = $db->getResult();

print_r($res);

