<?php
require '../vendor/autoload.php';

if (!empty($_COOKIE['rated'])) {
    $ratedIDs = json_decode(base64_decode($_COOKIE['rated']), TRUE);
} else {
    $ratedIDs = [];
}


$client = new MongoDB\Client(getenv('MONGO'));

$collection = $client->nuggets->nuggets;

$results = $collection->find(
    [
        "_id" => [
            '$nin' => array_map(function($alreadyRatedID) {return new MongoDB\BSON\ObjectID($alreadyRatedID); }, $ratedIDs)
        ]
    ]
)->toArray();

$returnData = [];
foreach ($results as $result) {
    $returnData[] = [
        'id' => (string)$result['_id'],
        'url' => $result['url']
    ];
}


header('Content-type:application/json');
echo json_encode($returnData)

?>