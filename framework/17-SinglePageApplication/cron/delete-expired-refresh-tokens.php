<?php
/**
 * This script will be excuted in CRON JOB
*/
declare(strict_types=1);


require __DIR__."/../vendor/autoload.php";


$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


/*
i$ sudo mysql -uroot -psecret123456!
[sudo] password for yao:
mysql: [Warning] Using a password on the command line interface can be insecure.
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 126
Server version: 8.0.32-0ubuntu0.22.04.2 (Ubuntu)

Copyright (c) 2000, 2023, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> use api_db;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
mysql> SELECT * FROM refresh_token;
+------------------------------------------------------------------+------------+
| token_hash                                                       | expires_at |
+------------------------------------------------------------------+------------+
| 14ff5d65f78929dbc81006f46b1c074bdf18302e53d90952a21b5d4273908d7b | 1683696403 |
| ad1946853353b6b179775a5dd38035c512c2bc00022a2536e42309e641e199d5 | 1683696407 |
+------------------------------------------------------------------+------------+
2 rows in set (0,00 sec)

mysql> INSERT INTO refresh_token (token_hash, expires_at) VALUES ("abc123", 1000);
Query OK, 1 row affected (0,01 sec)

mysql>
*/

/**
 * CRON COMMAND
 *
 * In your terminal TODO:
 * $ php cron/delete-expired-refresh-tokens.php
*/

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$refreshTokenGateway = new RefreshTokenGateway($database, $_ENV["JWT_SECRET_KEY"]);

$refreshTokenGateway->deleteExpired() ."\n";