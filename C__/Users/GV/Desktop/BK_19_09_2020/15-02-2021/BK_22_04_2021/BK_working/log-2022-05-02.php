<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-02 04:37:16 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 04:37:16 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-05-02 05:11:59 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 05:11:59 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-05-02 07:02:16 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 07:02:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2022-05-02 07:02:16 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2022-05-02 08:54:06 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 08:54:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2022-05-02 08:54:06 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2022-05-02 11:54:19 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 11:54:19 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2022-05-02 20:06:08 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2022-05-02 20:06:08 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2022-05-02 20:06:08 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981