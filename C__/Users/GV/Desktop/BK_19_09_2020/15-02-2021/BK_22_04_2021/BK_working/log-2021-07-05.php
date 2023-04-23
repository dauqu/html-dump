<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-07-05 10:56:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 122
ERROR - 2021-07-05 10:56:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 212
ERROR - 2021-07-05 11:04:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=
ERROR - 2021-07-05 11:04:26 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-07-05 11:04:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=
ERROR - 2021-07-05 11:04:30 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-07-05 11:04:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=
ERROR - 2021-07-05 11:04:37 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-07-05 11:04:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=
ERROR - 2021-07-05 11:04:48 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-07-05 11:05:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and sa.batch_id= and sa.meeting_date >=1577836800 and sa.meeting_date<=162544320' at line 3 - Invalid query: select bs.title as 'schedule',b.title as 'batch',u.student_first_name as 'student_first_name',
              u.student_last_name as 'student_last_name',sa.meeting_date  from student_attendance sa,batch_schedules bs,batches b,users u 
              where sa.schedule_id = bs.id and sa.batch_id = b.id and sa.user_id = u.id  and sa.user_id= and sa.batch_id= and sa.meeting_date >=1577836800 and sa.meeting_date<=1625443200
ERROR - 2021-07-05 11:05:43 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 776
ERROR - 2021-07-05 11:05:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and bs.batch_id=' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.course_id= and bs.batch_id=
ERROR - 2021-07-05 11:05:58 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-07-05 11:07:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=
ERROR - 2021-07-05 11:07:46 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-07-05 11:16:54 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/my_courses.php 52
ERROR - 2021-07-05 11:16:54 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/my_courses.php 210
ERROR - 2021-07-05 12:11:31 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 33
ERROR - 2021-07-05 12:13:12 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 33
ERROR - 2021-07-05 12:13:42 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 33
ERROR - 2021-07-05 12:17:04 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 33
ERROR - 2021-07-05 14:58:45 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 33
ERROR - 2021-07-05 15:05:35 --> Severity: error --> Exception: Cannot use object of type mysqli as array /var/www/html/application/views/backend/admin/batch_schedule_report.php 34
ERROR - 2021-07-05 15:06:18 --> Severity: error --> Exception: Cannot use object of type mysqli as array /var/www/html/application/views/backend/admin/batch_schedule_report.php 34
ERROR - 2021-07-05 15:06:55 --> Severity: error --> Exception: Cannot use object of type mysqli as array /var/www/html/application/views/backend/admin/batch_schedule_report.php 34
ERROR - 2021-07-05 17:25:36 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 122
ERROR - 2021-07-05 17:25:36 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 212
ERROR - 2021-07-05 17:30:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 122
ERROR - 2021-07-05 17:30:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 212
ERROR - 2021-07-05 22:06:48 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 122
ERROR - 2021-07-05 22:06:48 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 212
