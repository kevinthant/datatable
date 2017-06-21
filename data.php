<?php
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:25 PM
 */
require_once __DIR__ . '/vendor/autoload.php';

use Thant\DataTable\Handler;
use Thant\DataTable\DataProvider\StudentList;

$handler = new Handler(new StudentList());
$result = $handler->handle($_REQUEST);
echo json_encode($result);