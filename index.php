<?php

require_once './Includes/configs/functions.php';
include_once './Includes/configs/env.inc.php';

require_once './Includes/dofthings/autoload/autoload.php';
require_once './Includes/dofthings/app/dofthingsapp.php';

require_once "./Includes/configs/global.php";

$scriptName = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);

// Include config file specific for the script
if (file_exists("./Includes/configs/" . $scriptName . "")) {
    require_once "./Includes/configs/" . $scriptName . "";
}

use Dofthings\App\Main;

$app = Main::getInstance();
$app->run();
?>
