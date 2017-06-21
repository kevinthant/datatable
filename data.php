<?php
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:25 PM
 */
require_once __DIR__ . '/vendor/autoload.php';

use Thant\DataTable\Handler;
use Thant\DataTable\DataProvider\ArrayList;

function getSampleData()
{
    $columns = array(
        'Name',
        'Email',
        'Date Time'
    );

    $records = array();
    $name = 'A';
    $date = new DateTime();
    for($i = 0; $i < 100; $i++)
    {

        $records[] = array(
            'User '. $name,
            $name . '@gmail.com',
            $date->format('m/d/Y h:i:s a')
        );

        $name++;
        $date->add(new DateInterval('P1D'));
    }

    return array($columns, $records);
}

list($columns, $records) = getSampleData();

$handler = new Handler(new ArrayList($columns, $records));
$result = $handler->handle($_REQUEST);
echo json_encode($result);