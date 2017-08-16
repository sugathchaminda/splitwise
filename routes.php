<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('src/models/SplitBill.php');

function call($controller, $action) {
    require_once('src/controllers/' . $controller . 'Controller.php');

    switch($controller) {
        case 'SplitUpload':
            $controller = new SplitUploadController(new SplitBill());
            break;
    }

    $controller->{ $action }();
}

$controllers = array('SplitUpload' => ['index']);


call('SplitUpload', 'index');
