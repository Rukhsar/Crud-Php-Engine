<?php

include('class/crud_engine.php');

$db = new CrudEngine();

$db->connect();

// Table name, WHERE conditions

$db->delete('CRUD','id=5');

$res = $db->getResult();

print_r($res);