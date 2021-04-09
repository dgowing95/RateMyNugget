<?php
require '../vendor/autoload.php';
// assert_options(ASSERT_CALLBACK, 'assertHandler');

if (!empty($_COOKIE['rated'])) {
    $ratedIDs = json_decode(base64_decode($_COOKIE['rated']), TRUE);
} else {
    $ratedIDs = [];
}

$ratedObjectIDs = array_map(function($alreadyRatedID) {return new MongoDB\BSON\ObjectId($alreadyRatedID); }, $ratedIDs);

$client = new MongoDB\Client(getenv('MONGO'));

$collection = $client->nuggets->nuggets;

$results = $collection->aggregate([
    [
        '$match' => [
            '_id' => [
                '$nin' => $ratedObjectIDs
            ]
        ],
    ],
    [
        '$addFields' => [
            'rating' => [
                '$cond'=> [ 
                    [ 
                        '$eq'=> [ '$rateSubmissions', 0 ] 
                    ],
                    0,
                    [
                        '$divide' => ['$rateValue', '$rateSubmissions']
                    ]
                ]
            ]
        ]
    ],
    [
        '$sample' => [
            'size' => 10
        ]
    ]
    

    
])->toArray();

$returnedIDs = array_map(function($entry) {
    return (string)$entry['_id'];
}, $results);

$previouslySeenImages = array_diff($returnedIDs, $ratedIDs);
// assert(sizeof($previouslySeenImages) === 10);


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
echo json_encode($returnData);


// function assertHandler($file, $line, $code) {
//     echo "<hr>Assertion Failed:
//         File '$file'<br />
//         Duplicate Items '$line'<br />
//         Code '$code'<br /><hr />
//         Value of cookie was: " . ($_COOKIE['rated'] ?? 'Missing') . "<br />";
// }
?>