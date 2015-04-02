# contracts-base
This is contracts database based in MySQL and PHP
NOTE! This project now not have admin panel, therefore you necessary use phpmyadmin or another soft for change/delete/input some data
Now this portal not have admin panel, maybe it will added to next realises, but i think that administrator panel no needed, because all issues can be solved through users permissions.

## How to install
 - Copy files from directory "codeigniter-files" to your web root;
 - set 777 permissions for "upload" catalog;
 - Create new  MySQL  DB named "contracts"
 - Import to your DB "contracts.sql"
 - Open database.php in config directory and change:

````php
'hostname' => 'your DB hostname',
'username' => 'your DB user',
'password' => 'your DB password',
'database' => 'contracts', - or another, if you change DB name
'dbdriver' => 'mysqli',
````
 - add to the "departments" table your departments who will use this portal, because without it impossible create new user. (First created user will be administrator of portal).
After registration you get full access to portal

## User guide
Now i have only user guide in russian, if you administrator please contact to me, i will help you set up the portal.

