# MyDb Database Util class for php

> Easy Way To Access and Database and Perform Database Operations

-

## First Include  MyDb.php in Your Php Script

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

#### Return Type
<<<<<<< HEAD
`array`
Which Contain Retrive Data in associative array format 
=======
Type:`array`
array Which Contain Retrive Data in associative array format 

```php
$data = $db->query(
 			"SELECT  count(username)  as total 
			from
			users_master ");
```

 
### Insert Data in Table 
#### Parameters
<<<<<<< HEAD
1 `string` 
for Table name
	 
2 `array`
=======
1 `string` 
for Table name
	 
2 `array`
associative array for insert Data	

```php
$db->insert("users_master",
			array(
			"username"=>"uzaif",
			"password"=>"password")); 
```
### Update Data in Table
#### Parameters
<<<<<<< HEAD
1 `string` 
for Table name
	 
2 `array`
for Actual Data for Update	
	 
3 `string`
=======
1 `string` 
for Table name
	 
2 `array`
for Actual Data for Update	
	 
3 `string`
where clause of sql Update	

	
```php
$db->update("users_master",
				  array(
				  "password"=>"somepassword"),
				  "username='uzaif'");
```
