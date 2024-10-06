<?php
define('DBHOST', 'localhost');
define('DBNAME', 'f1');
define('DBUSER', '');
define('DBPASS', '');
// '__DIR__' gives the path to config.inc.php file
//'/../data/f1.db' moves up one folder and looks for the 'f1.db' file in the 'data' folder.
define('DBCONNSTRING', 'sqlite:' . __DIR__ . '/../data/f1.db');
