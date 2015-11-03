# MyDb Database Util class for php

> Easy Way To Access and Database and Perform Database Operations

-

## First Include This MyDb.php in Your Php Script

```php
include 'MyDB.php';
```

### Making Database Connection

```php
$config=array(
"host"=>"Your host name",//localhost 
"user"=>"username",//root
"password"=>"",//password
"database"=>"your database name"//database name
);
$db=new DB($config);
```
### Executing SQL Raw Query and Getting Rusult in  Array Form

```php

	$data = $db->query(
			"SELECT  count(username)  as total 
			from
			users_master ");
```

### Insert Data in Specefic Table 

```php
	$db->insert("users_master",
				array(
				"username"=>"uzaif",
				"password"=>"password")); 
```

