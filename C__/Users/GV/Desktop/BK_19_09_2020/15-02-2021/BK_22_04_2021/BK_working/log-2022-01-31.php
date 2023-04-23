<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-31 02:43:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-01-31 02:43:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-01-31 12:49:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-01-31 12:49:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-01-31 19:01:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3 - Invalid query: SELECT DISTINCT `user_id`
FROM `enrol`
WHERE `course_id` IN()
ERROR - 2022-01-31 19:01:00 --> Severity: error --> Exception: Call to a member function num_rows() on boolean /var/www/html/application/views/frontend/default/instructor_page.php 53
ERROR - 2022-01-31 21:19:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-01-31 21:19:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-01-31 22:43:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-01-31 22:43:51 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2022-01-31 22:43:51 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
