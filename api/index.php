<?php
define("ROOT_DIR" , dirname(__FILE__));

require_once(ROOT_DIR . "/Server.php");

$input = file_get_contents("php://input");

$server = new Server($input);
$result = $server->process();

echo $result;
exit();