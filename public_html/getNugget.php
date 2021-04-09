<?php
require '../vendor/autoload.php';

if (!empty($_COOKIE['rated'])) {
    $ratedIDs = json_decode(base64_decode($_COOKIE['rated']), TRUE);
} else {
    $ratedIDs = [];
}


$client = new MongoDB\Client(getenv('MONGO'));

$collection = $client->nuggets->nuggets;

$results = $collection->aggregate([
    [
        '$match' => [
            '_id' => [
                '$nin' => array_map(function($alreadyRatedID) {return new MongoDB\BSON\ObjectID($alreadyRatedID); }, $ratedIDs)
            ]
        ],
    ],
    [
        '$addFields' => [
            'rating' => [
                '$divide' => ['$rateValue', '$rateSubmissions']
            ]
        ]
    ],
    [
        '$sample' => [
            'size' => 10
        ]
    ]
    

    
])->toArray();

//Randomize order
shuffle($results);


$returnData = [];
foreach ($results as $result) {
    $returnData[] = [
        'id' => (string)$result['_id'],
        'url' => $result['url'],
        'rating' => $result['rating'],
        'numRates' => $result['rateSubmissions']
    ];
}


header('Content-type:application/json');
echo json_encode($returnData)

?>