<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-07-10 05:54:17 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-10 05:54:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-10 05:54:17 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-07-10 22:20:07 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-10 22:20:07 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-10 22:20:07 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-07-10 22:30:36 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-07-10 22:30:36 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-07-10 22:30:36 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-07-10 23:05:12 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3 - Invalid query: SELECT DISTINCT `user_id`
FROM `enrol`
WHERE `course_id` IN()
ERROR - 2021-07-10 23:05:12 --> Severity: error --> Exception: Call to a member function num_rows() on boolean /var/www/html/application/views/frontend/default/instructor_page.php 53
ERROR - 2021-07-10 23:05:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3 - Invalid query: SELECT DISTINCT `user_id`
FROM `enrol`
WHERE `course_id` IN()
ERROR - 2021-07-10 23:05:13 --> Severity: error --> Exception: Call to a member function num_rows() on boolean /var/www/html/application/views/frontend/default/instructor_page.php 53
ERROR - 2021-07-10 23:47:50 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/controllers/Home.php 523
