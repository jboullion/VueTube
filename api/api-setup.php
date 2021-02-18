<?php 
/** 
 * Setup the database connection and other global objects needed to use the api
 * 
 * Long term goal would be to setup a Symfony or other backend API. But for now the PDO should work
*/

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Cache-Control: max-age=0');
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set("America/Chicago");

require_once dirname(__FILE__).'/vendor/autoload.php';

require_once 'api-tables.php';

$pdo = new PDO('mysql:host=localhost;dbname=mytube', 'root', '');

// jb_create_tables($pdo);