<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-05 10:07:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-11-05 10:07:02 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-11-05 10:07:02 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
ERROR - 2021-11-05 20:49:18 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-11-05 20:49:18 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 259
ERROR - 2021-11-05 21:28:19 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 164
ERROR - 2021-11-05 21:28:19 --> Query error: Unknown column 'shopping_cart' in 'where clause' - Invalid query: select b.* from batches b,batch_schedules bs where b.id = bs.batch_id and b.course_id =shopping_cart and bs.start_time > UNIX_TIMESTAMP() group by b.id
ERROR - 2021-11-05 21:28:19 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Crud_model.php 981
