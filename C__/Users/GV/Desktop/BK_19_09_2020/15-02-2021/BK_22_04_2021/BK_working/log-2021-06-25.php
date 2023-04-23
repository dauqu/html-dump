<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-25 00:21:53 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 00:21:53 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 01:00:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 01:00:51 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 02:25:26 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 02:25:26 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 03:25:47 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 03:25:47 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 05:54:14 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 05:54:14 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'id' /var/www/html/application/views/payment/payment_gateway.php 302
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 313
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'id' /var/www/html/application/views/payment/payment_gateway.php 302
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 313
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'id' /var/www/html/application/views/payment/payment_gateway.php 302
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 313
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> A non-numeric value encountered /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> A non-numeric value encountered /var/www/html/application/views/payment/payment_gateway.php 318
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'price' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> Illegal string offset 'qty' /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> A non-numeric value encountered /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:33 --> Severity: Warning --> A non-numeric value encountered /var/www/html/application/views/payment/payment_gateway.php 319
ERROR - 2021-06-25 05:54:47 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 05:54:47 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 06:42:46 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/batch_schedule_report.php 26
ERROR - 2021-06-25 06:44:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and p.batch_id=7 and p.date_added>=1579564800 and p.schedule_last_date<=16245792' at line 4 - Invalid query: select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id and p.user_id= and p.batch_id=7 and p.date_added>=1579564800 and p.schedule_last_date<=1624579200
ERROR - 2021-06-25 06:44:14 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 714
ERROR - 2021-06-25 07:25:53 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:25:53 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:25:53 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 07:26:26 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:26:26 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:26:26 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-06-25 07:27:00 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:27:00 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:27:00 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-06-25 07:28:37 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:28:37 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:28:37 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-06-25 07:29:12 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:29:12 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:29:12 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-06-25 07:29:14 --> Severity: Warning --> mysqli::query(): Empty query /var/www/html/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2021-06-25 07:29:14 --> Query error:  - Invalid query: 
ERROR - 2021-06-25 07:29:14 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 716
ERROR - 2021-06-25 07:40:46 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/html/application/views/backend/admin/student_attendance_report.php 25
ERROR - 2021-06-25 07:40:50 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/html/application/views/backend/admin/student_attendance_report.php 25
ERROR - 2021-06-25 07:42:12 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/html/application/views/backend/admin/student_attendance_report.php 25
ERROR - 2021-06-25 08:51:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as 'schedule',b.title as 'batch',u.student_first_name as 'student_first_name',
              u.student_last_name as 'student_last_name',sa.meeting_date  from student_attendance sa,batch_schedules bs,batches b,users u 
              where sa.schedule_id = bs.id and sa.batch_id = b.id and sa.user_id = u.id  and sa.user_id=all
ERROR - 2021-06-25 08:51:46 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 776
ERROR - 2021-06-25 09:13:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as 'schedule',b.title as 'batch',u.student_first_name as 'student_first_name',
              u.student_last_name as 'student_last_name',sa.meeting_date  from student_attendance sa,batch_schedules bs,batches b,users u 
              where sa.schedule_id = bs.id and sa.batch_id = b.id and sa.user_id = u.id  and sa.user_id=all
ERROR - 2021-06-25 09:13:41 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 776
ERROR - 2021-06-25 09:58:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 09:58:14 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 09:59:32 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 09:59:32 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 09:59:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 09:59:34 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:00:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:00:23 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:00:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:00:34 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:00:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:00:46 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:01:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:01:16 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:01:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:01:17 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:02:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:02:23 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:02:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id and bs.batch_id=
ERROR - 2021-06-25 10:02:25 --> Severity: error --> Exception: Call to a member function result_array() on boolean /var/www/html/application/models/Batch_model.php 746
ERROR - 2021-06-25 10:30:41 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 10:30:41 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 10:53:04 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 10:53:04 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:01:05 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:01:05 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:06:35 --> Severity: error --> Exception: Class 'Date' not found /var/www/html/application/controllers/Admin.php 1841
ERROR - 2021-06-25 11:07:37 --> Severity: error --> Exception: Class 'Date' not found /var/www/html/application/controllers/Admin.php 1841
ERROR - 2021-06-25 11:09:02 --> Severity: error --> Exception: Class 'Date' not found /var/www/html/application/controllers/Admin.php 1841
ERROR - 2021-06-25 11:25:10 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:10 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:25:23 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:23 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:25:24 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:24 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:25:26 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:26 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:25:27 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:27 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:25:43 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:25:43 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:26:57 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:26:57 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 11:27:33 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 11:27:33 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 12:06:25 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 12:06:25 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 12:07:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 26
ERROR - 2021-06-25 12:07:56 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/backend/admin/student_attendance_report.php 39
ERROR - 2021-06-25 12:31:21 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 12:31:21 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 13:14:50 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 13:14:50 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 13:29:31 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 13:29:31 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 17:03:15 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 17:03:15 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 17:12:48 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 17:12:48 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 17:44:21 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 17:44:21 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 20:32:39 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 20:32:39 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 21:57:35 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 21:57:35 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 22:03:05 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 22:03:05 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
ERROR - 2021-06-25 22:50:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 98
ERROR - 2021-06-25 22:50:02 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/application/views/frontend/default/course_page.php 188
