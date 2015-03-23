# contracts-base
This is contracts database based in MySQL and PHP
 - NOTE! This project now not have admin panel, therefore you necessary use phpmyadmin or another soft for change/delete/input some data
 - Now this portal not have admin panel, maybe it will added to next realises, but i think that administrator panel no needed, because all issues can be solved through users permissions.

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

