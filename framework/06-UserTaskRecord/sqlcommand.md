i$ sudo mysql -uroot -psecret123456!
[sudo] password for yao:
mysql: [Warning] Using a password on the command line interface can be insecure.
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 46
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
mysql> ALTER TABLE task
-> ADD user_id INT NOT NULL,
-> ADD INDEX (user_id);
Query OK, 0 rows affected (0,15 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> DESCRIBE task;
+--------------+--------------+------+-----+---------+----------------+
| Field        | Type         | Null | Key | Default | Extra          |
+--------------+--------------+------+-----+---------+----------------+
| id           | int          | NO   | PRI | NULL    | auto_increment |
| name         | varchar(128) | NO   | MUL | NULL    |                |
| priority     | int          | YES  |     | NULL    |                |
| is_completed | tinyint(1)   | NO   |     | 0       |                |
| user_id      | int          | NO   | MUL | NULL    |                |
+--------------+--------------+------+-----+---------+----------------+
5 rows in set (0,01 sec)

mysql> SELECT * FROM task;
+----+----------------+----------+--------------+---------+
| id | name           | priority | is_completed | user_id |
+----+----------------+----------+--------------+---------+
|  1 | Buy news shoes |        1 |            1 |       0 |
|  2 | Renew passport |        2 |            0 |       0 |
|  3 | Paint wall     |     NULL |            1 |       0 |
|  4 | Changed 2ddd   |        8 |            0 |       0 |
|  6 | Task 3         |     NULL |            0 |       0 |
+----+----------------+----------+--------------+---------+
5 rows in set (0,00 sec)

mysql> SELECT * FROM user;
+----+------+----------+--------------------------------------------------------------+----------------------------------+
| id | name | username | password_hash                                                | api_key                          |
+----+------+----------+--------------------------------------------------------------+----------------------------------+
|  1 | Dave | dave     | $2y$10$IKNro3wCRonRjv3cNuMlROBteah1H6Ip0STnIOMN9MgArw1b6s412 | cdd34f392f5aa263a54d869a852ae19e |
+----+------+----------+--------------------------------------------------------------+----------------------------------+
1 row in set (0,00 sec)

mysql> UPDATE task SET user_id = 1;
Query OK, 5 rows affected (0,00 sec)
Rows matched: 5  Changed: 5  Warnings: 0

mysql> SELECT * FROM task;
+----+----------------+----------+--------------+---------+
| id | name           | priority | is_completed | user_id |
+----+----------------+----------+--------------+---------+
|  1 | Buy news shoes |        1 |            1 |       1 |
|  2 | Renew passport |        2 |            0 |       1 |
|  3 | Paint wall     |     NULL |            1 |       1 |
|  4 | Changed 2ddd   |        8 |            0 |       1 |
|  6 | Task 3         |     NULL |            0 |       1 |
+----+----------------+----------+--------------+---------+
5 rows in set (0,00 sec)

mysql> ALTER TABLE task
-> ADD FOREIGN KEY (user_id)
-> REFERENCES user(id)
-> ON DELETE CASCADE ON UPDATE CASCADE;
Query OK, 5 rows affected (0,03 sec)
Records: 5  Duplicates: 0  Warnings: 0

mysql> 
