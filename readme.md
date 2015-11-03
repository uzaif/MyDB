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
`array`
Which Contain Retrive Record in associative array format 

```php
$data = $db->query(
 			"SELECT  count(username)  as total 
			from
			users_master ");
```

 
### Insert Record in Table 

#### Parameters

1 `string` 
for Table name
	 
2 `array`
associative array for insert Record	

```php
$db->insert("users_master",
			array(
			"username"=>"uzaif",
			"password"=>"password")); 
```
### Update Record in Table
#### Parameters
1 `string` 
for Table name
	 
2 `array`
for Actual Record for Update	
	 
3 `string`
where clause of sql	

	
```php
$db->update("users_master",
				  array(
				  "password"=>"somepassword"),
				  "username='uzaif'");
```

### Delete Record from Table

#### Parameters
1 `string` for Table Name
2 `string` for Where Clause of Sql

```php
$db->delete("users_master","username='uzaif'");
```
