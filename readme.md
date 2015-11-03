# MyDb Database Util class for php

> Easy Way To Access and Database and Perform Database Operations

-



## Makeing Database Connection

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

