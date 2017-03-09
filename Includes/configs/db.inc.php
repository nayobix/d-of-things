<?php

//set local variables
$dbtype = "MySQL"; //choose db type you want to connect to use MySQL, MySQLi or PostGreSQL as examples
$dbhost = "localhost";
$dbuser = "dofthings";
$dbpass = "dofthingsd0fth1ngs";
$dbname = "dofthings";

//connection error messages used for database user and password or type failures
DEFINE("DATABASE_CONNECTION_ERROR", "<h1>Fatal Error:</h1><p>Unable to connect to the database at this time.</p>");
DEFINE("DATABASE_LOCATION_ERROR", "<h1>Fatal Error:</h1><p>Unable to locate the database at this time.</p>");
DEFINE("DATABASE_EMPTY_ERROR", "<h1>Fatal Error:</h1><p>Unable to locate data it appears your database is empty.</p>");
DEFINE("DATABASE_UNSUPPORTED_DATABASE_TYPE_ERROR", "<h1>Fatal Error:</h1><p>Your server does not support access to a $dbtype Database.</p>");
//debug message used when debugging is turn on or off
DEFINE("DEBUG_SQL_TURN_OFF_VERBOSE_MESSAGE", "<h1>Fatal Error:</h1><p>There was an error somewhere in your script.</p>");

//choose the right connector to setup
switch ($dbtype) {
    //connect to MySQL
    case 'MySQL':
        if (function_exists('mysql_connect')) {
            include_once "db.functions.$dbtype.php";
        } else {
            die(DATABASE_UNSUPPORTED_DATABASE_TYPE_ERROR);
            exit();
        }
        break;
    //connect to MySQLi
    case 'MySQLi':
        if (function_exists('mysqli_connect')) {
            include_once "db.functions.$dbtype.php";
        } else {
            die(DATABASE_UNSUPPORTED_DATABASE_TYPE_ERROR);
            exit();
        }
        break;
    default:
        die(DATABASE_LOCATION_ERROR);
        break;
}
?>
