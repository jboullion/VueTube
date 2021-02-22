<?php 
/** 
 * Setup the database connection and other global objects needed to use the api
 * 
 * Long term goal: Symfony backend API.
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Cache-Control: max-age=0');
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set("America/Chicago");

global $pdo;

// IMPORTANT: If you add another package here please remove Google Client IF it is no longer in use.
//require_once dirname(__FILE__).'/vendor/autoload.php';

require_once 'api-functions.php';

// SETUP our DB connection
$host = 'localhost';
$db   = 'mytube';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


// DEFAULT global variables
$DEFAULT_VID_LIMIT = 30;