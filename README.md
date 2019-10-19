# Login System with Application "Run Tracker" for course 1dv610

You can find the application here: [young-woodland-37975.herokuapp.com/](https://young-woodland-37975.herokuapp.com/)

## Use Cases and Test Cases

### Login:
[Use Case](https://github.com/niklasnilsson87/1dv610_lab2/wiki/Use-Case-for-Login)  
[Test Case](https://github.com/niklasnilsson87/1dv610_lab2/wiki/Test-Case-for-Login)

`92%` of the automatic tests fullfilled.  
`92%` of the manual tests fullfilled.

### Run Application:
[Use Case](https://github.com/niklasnilsson87/1dv610_lab2/wiki/Use-Case-for-Run-Application)  
[Test Case](https://github.com/niklasnilsson87/1dv610_lab2/wiki/Test-Case-for-Run-Application)

`100%` of the manual tests fullfilled.

Read more about the Run Application [Run Tracker](https://github.com/niklasnilsson87/1dv610_lab2/wiki/RunTracker)

## Setup

I assume that you know a little bit of how php projects work.

if you want to setup your own project you need to configure the LocalSettings.php and ProductionSettings.php

### LocalSettings.php

You need this to configure you phpmyadmin localy.
And you can configure with your preferences.

```
<?php

namespace Login\Model;

class LocalSettings {
  public $server_name = 'localhost';
  public $db_name = 'root';
  public $db_password = '';
  public $database = 'users';
}

```

### ProductionSettings.php

You need this to configure you database in production.
This is setup for the [JawsDB](https://www.jawsdb.com/) database with the extension with [adminium](adminium.io) for creating tables.

```
<?php

namespace Login\Model;

class ProductionSettings {
  public $server_name;
  public $db_name;
  public $db_password;
  public $database;

  public function __construct() {
    $url = getenv('JAWSDB_URL');
    $dbparts = parse_url($url);

    $this->server_name = $dbparts['host'];
    $this->db_name = $dbparts['user'];
    $this->db_password = $dbparts['pass'];
    $this->database = ltrim($dbparts['path'],'/');
  }
}

```

create .env file in the root with the variable you get from JawsDB
```
JAWSDB_URL='YOUR CONNECTION STRING HERE'
```
## Database

In your database you need two tables that is configured like this:

### Table `users`

| Name | Type | Null | Extra |
| ----------- | ----------- | ----------- | ----------- |
| id | int(11) | NOT NULL | AUTO_INCREMENT & PRIMARY_KEY |
| username | varchar(128) | NOT NULL | UNIQUE |
| password | text | NOT NULL |  |

### Table `runs`

| Name | Type | Null | Extra |
| ----------- | ----------- | ----------- | ----------- |
| id | int(11) | NOT NULL | AUTO_INCREMENT & PRIMARY_KEY |
| username | varchar(128) | NOT NULL |  |
| distance | text | NOT NULL | |
| time | text | NOT NULL | |
| pace | text | NOT NULL | |
| date | text | NOT NULL | |
