<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-12-28 06:51:31 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-12-28 06:51:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.start_time > UNIX_TIMESTAMP() group by b.id' at line 1 - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id = and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-12-28 06:51:31 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
