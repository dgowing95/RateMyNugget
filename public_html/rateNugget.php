<?php

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

//Only allow ratings that are ints 0-5 inclusive
if (
    filter_input(INPUT_GET, "rating", FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 5]]) ||
    filter_input(INPUT_GET, "rating", FILTER_VALIDATE_INT) === 0
) {
    $rating = $_GET['rating'];
} else {
    http_response_code(403);
    die('Forbidden');
}



//Store rated as a cookie so user doesnt get shown same image more than once
if (!empty($_COOKIE['rated'])) {
    $ratedIDs = json_decode(base64_decode($_COOKIE['rated']), TRUE);
} else {
    $ratedIDs = [];
}

$ratedIDs[] = $id;
$ratedIDs = array_unique($ratedIDs);

setcookie(
    'rated',
    base64_encode(json_encode($ratedIDs)),
    time()+60*60*24*30 
);


require '../vendor/autoload.php';

//Add rating to monodb doc
$client = new MongoDB\Client(getenv('MONGO'));
$collection = $client->nuggets->nuggets;
$nugget = $collection->findOneAndUpdate(
    ["_id" => new MongoDB\BSON\ObjectId($id)],
    [
        '$inc' => [
            'rateValue' => intval($rating),
            'rateSubmissions' => 1
        ]
    ]
);

//Reply to frontend so it can continue
header('Content-type:application/json');
echo json_encode([
    'status' => 'ok'
])

?>