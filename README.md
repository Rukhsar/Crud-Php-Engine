# Crud PHP Engine backed with MySQL

A simple PHP Class for using with MySQL create, read, update and delete functions. Using OOP this class can easily be added to to enhance existing functions or create more.

## Using The Class

### Database Credentials

You will need to change some variable values in the Class, that represent those of your own database.

### Test MySQL

Start by creating a test table in your database -

``` sql
CREATE TABLE IF NOT EXISTS CRUD (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO CRUD VALUES('','Name 1','name1@email.com');
INSERT INTO CRUD VALUES('','Name 2','name2@email.com');
INSERT INTO CRUD VALUES('','Name 3','name3@email.com');
```

### Join Example

Start by creating another table in your database 

``` sql
CREATE TABLE IF NOT EXISTS CRUDChild (
  id int(11) NOT NULL AUTO_INCREMENT,
  parentId int(11) NOT NULL,
  name varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO CRUDChild VALUES('','1','Child 1');
INSERT INTO CRUDChild VALUES('','1','Child 2');
INSERT INTO CRUDChild VALUES('','2','Child 1');

```

