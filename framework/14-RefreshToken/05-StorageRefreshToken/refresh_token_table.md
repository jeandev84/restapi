mysql> CREATE TABLE refresh_token (token_hash VARCHAR(64) NOT NULL, expires_at INT UNSIGNED NOT NULL, PRIMARY KEY (token_hash), INDEX (expires_at));
Query OK, 0 rows affected (0,07 sec)

mysql> DESCRIBE refresh_token;
+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| token_hash | varchar(64)  | NO   | PRI | NULL    |       |
| expires_at | int unsigned | NO   | MUL | NULL    |       |
+------------+--------------+------+-----+---------+-------+
2 rows in set (0,01 sec)

mysql> SHOW indexes FROM refresh_token;
+---------------+------------+------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table         | Non_unique | Key_name   | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+---------------+------------+------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| refresh_token |          0 | PRIMARY    |            1 | token_hash  | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| refresh_token |          1 | expires_at |            1 | expires_at  | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+---------------+------------+------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
2 rows in set (0,01 sec)

mysql> 
