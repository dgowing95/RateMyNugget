<?php
require '../vendor/autoload.php';

$client = new MongoDB\Client("");

header('Content-type:application/json');
echo json_encode([
    [
        '_id' => '0',
        'url' => 'https://placekitten.com/400/400'
    ]
])

?>