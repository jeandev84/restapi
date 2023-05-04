$ sudo mysql -uroot -psecret123456!
[sudo] password for yao:
mysql: [Warning] Using a password on the command line interface can be insecure.
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 26
Server version: 8.0.32-0ubuntu0.22.04.2 (Ubuntu)

Copyright (c) 2000, 2023, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show tables;
ERROR 1046 (3D000): No database selected
mysql> clear
mysql> show databases;
+------------------------+
| Database               |
+------------------------+
| api_db                 |
| apiplatform            |
| doctrineorm            |
| ecommerce_mini_project |
| eshoprmq               |
| information_schema     |
| lexus                  |
| mysql                  |
| performance_schema     |
| products_api           |
| products_api_test      |
| shop                   |
| specialist_eshop_goods |
| specialist_guestbook   |
| specialist_oop_eshop   |
| specialist_web         |
| symfony                |
| sys                    |
| videos                 |
+------------------------+
19 rows in set (0,01 sec)

mysql> use api_db;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
mysql> clear
mysql> CREATE TABLE user (id INT NOT NULL AUTO_INCREMENT,
-> name VARCHAR(128) NOT NULL,
-> username VARCHAR(128) NOT NULL,
-> password_hash VARCHAR(255) NOT NULL,
-> api_key VARCHAR(255) NOT NULL,
-> PRIMARY KEY (id),
-> UNIQUE (username),
-> UNIQUE (api_key)
-> );
Query OK, 0 rows affected (0,03 sec)

mysql> DECRIBE user;
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'DECRIBE user' at line 1
mysql> DESCRIBE user;
+---------------+--------------+------+-----+---------+----------------+
| Field         | Type         | Null | Key | Default | Extra          |
+---------------+--------------+------+-----+---------+----------------+
| id            | int          | NO   | PRI | NULL    | auto_increment |
| name          | varchar(128) | NO   |     | NULL    |                |
| username      | varchar(128) | NO   | UNI | NULL    |                |
| password_hash | varchar(255) | NO   |     | NULL    |                |
| api_key       | varchar(255) | NO   | UNI | NULL    |                |
+---------------+--------------+------+-----+---------+----------------+
5 rows in set (0,01 sec)

mysql> SHOW indexes FROM user;
+-------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table | Non_unique | Key_name | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+-------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| user  |          0 | PRIMARY  |            1 | id          | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| user  |          0 | username |            1 | username    | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| user  |          0 | api_key  |            1 | api_key     | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+-------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
3 rows in set (0,01 sec)

mysql> 
