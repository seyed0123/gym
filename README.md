<div align="center">

# Gym Management System

<img src="shots/gym.jpg" width="50%">

A PHP-based application crafted to optimize and simplify gym management. It offers an intuitive interface for efficiently managing memberships, tracking attendance, processing billing, and scheduling classes, ensuring seamless operation and enhanced member satisfaction.
</div>

## Features
- Member Management: Add, update, and delete member profiles, track memberships, and manage renewals.
- Attendance Tracking: Record and monitor daily attendance with creating session for them.
- Program Management: Add ,update and delete program and exercise and assign programs to the users.
- Reports: Generate detailed reports on member activity, and class attendance.

## Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache or Nginx web server

## Installation
### 1- Clone the repository
```shell
git clone https://github.com/seyed0123/gym.git
cd gym
```
### 2- Set up the database
- Install the mysql composer lib.
- Create a MySQL database.
- enter the database info in the [db](php/db_connect.php) file.
- create tables using [table](table.sql) file

### 3- Setup admin user
- set the admin username and password in the [admin](admin.json) file
- default admin username and password is (username = `admin` , passwords =`1234`)
- you can generate the admin password hash using [test](test.php) file.

## Database
![db](shots/db.png)

## Screenshots
### login
![login](shots/login.png)
### sign up
![sigup](shots/signup.png)
### user
![home1](shots/home_guest1.png)
![home2](shots/home_guest2.png)
![home3](shots/home_guest3.png)
### admin
![home admin](shots/home_admin1.png)
#### new session
![new session](shots/newsession.png)
#### search user
![search user](shots/searchuser.png)
![edit user](shots/searchuser2.png)
#### new program
![new program 1](shots/newprogram1.png)
![new program 2](shots/newprogram2.png)
![new program 3](shots/newprogram3.png)
![new program 4](shots/newprogram4.png)
### **The site support the mobile view as well**
![home mobile](shots/home_mobile.png)
![new session mobile](shots/newsession_mobile.png)

##Contributing
feel free to send the pull requests 
