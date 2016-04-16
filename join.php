<?php

include('class/crud_engine.php');

$db = new CrudEngine();

$db->connect();

// Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions

$db->select('CRUD','CRUD.id,CRUD.name,CRUDChild.name','CRUDChild ON CRUD.id = parentId','CRUD.name="Name 1"','id DESC');

$res = $db->getResult();

print_r($res);