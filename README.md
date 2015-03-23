# Contracts-base

  This contracts portal based on MySQL and PHP, portal can help small companies organize contract docflow. This project based on Russian law (223 Federal act), but also can used commercial companies with some small changes.

  NOTE! Now this project no have admin panel, therefore you necessary use phpmyadmin or another tools for change/delete/input some data it will solved in next realises.
  Also perhaps adminpanel will added to next realises, but i think this tool no necessary, because all issues can be solved through users permissions.

## How to install

 - First of all download last revision of Codeigniter 3 (http://www.codeigniter.com/);
 - Unpack the Codeigniter into your web root directory;
 - Copy contracts files to your web root (repalce all files which have same file name);
 - set 777 permissions for "upload" catalog;
 - Create new  MySQL  DB named "contracts"
 - Import to your DB "contracts.sql"
 - Open database.php in config directory and change:

    'hostname' => 'your DB hostname',
    'username' => 'your DB user',
    'password' => 'your DB password',
    'database' => 'contracts', - or another, if you change DB name
    'dbdriver' => 'mysqli',

 - add to the "departments" table your departments who will use this portal, because without it impossible create new user. (First created user will be administrator of portal).
After registration you get full access to portal

## Roadmap

 Add new tools for user and database management;
 Add docflow for crating notes and letters:
 Add LDAP authentication;
 Add invoices management and control contracts cost.
