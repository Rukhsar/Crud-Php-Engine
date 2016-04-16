<?php

include('class/crud_engine.php');

$db = new CrudEngine();

$db->connect();

// Table name, column names and values, WHERE conditions

$db->update('CRUD',array('name'=>"Name 4",'email'=>"name4@email.com"),'id="1" AND name="Name 1"');

$res = $db->getResult();

print_r($res);