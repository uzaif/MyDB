# MyDb Database Util class for php

> Easy Way To Access and Database and Perform Database Operations

-



## Making Database Connection

```php
<?php
include 'MyDB.php';
$config=array(
"host"=>"Your host name",//localhost 
"user"=>"username",//root
"password"=>"",//password
"database"=>"your database name"//database name
);
$db=new DB($config);
```
## Executing SQL Raw Query and Getting Rusult in  Array Form

```php
<?php
	$data = $db->query(
			"SELECT  count(username)  as total 
			from
			users_master ");
```


