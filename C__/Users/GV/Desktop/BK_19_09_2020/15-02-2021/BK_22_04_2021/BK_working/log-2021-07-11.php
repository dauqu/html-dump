<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-07-11 01:53:33 --> Severity: Warning --> sizeof(): Parameter must be an array or an object that implements Countable /var/www/html/application/models/Crud_model.php 1678
ERROR - 2021-07-11 09:03:23 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-11 09:03:23 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2021-07-11 14:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-11 14:09:02 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-11 14:09:02 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-07-11 16:16:43 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-11 16:16:43 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-11 16:16:43 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-07-11 16:24:16 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR), expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' /var/www/html/application/controllers/User.php 18
ERROR - 2021-07-11 18:19:20 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-11 18:19:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-11 18:19:20 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
