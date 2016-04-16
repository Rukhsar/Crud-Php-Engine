<?php

include('class/crud_engine.php');

$db = new CrudEngine();

$db->connect();

// Escape any input before insert

$data = $db->escapeString("name5@email.com");

// Table name, column names and respective values

$db->insert('CRUD',array('name'=>'Name 5','email'=>$data));

$res = $db->getResult();

print_r($res);