<?php
require '../vendor/autoload.php';
$client = new MongoDB\Client(getenv('MONGO'));
$collection = $client->nuggets->nuggets;

if (empty($_GET['key']) || $_GET['key'] != getenv('SYNC_KEY')) {
    http_response_code(403);
    die('Forbidden');
}

Unsplash\HttpClient::init([
	'applicationId'	=> getenv('UNSPLASH_KEY'),
	'secret'	=> getenv('UNSPLASH_SECRET'),
	'utmSource' => 'Rate My Nugget'
]);

$search = 'nugget';
$page = 1;
$per_page = 30;

$response = Unsplash\Search::photos($search, $page, $per_page);
$totalImages = $response->getTotal();
$totalPages = $response->getTotalPages();

echo "$totalImages images found <br>";

$images = $response->getResults();
uploadPageResults($images, $collection);
$page++;

while ($page <= $totalPages) {
	$response = Unsplash\Search::photos($search, $page, $per_page);
	$images = $response->getResults();
	uploadPageResults($images, $collection);
	$page++;
}







function uploadPageResults($images, $collection) {
	$documents = [];
	foreach ($images as $image) {
		$documents[] = [
			'url' => $image['urls']['small'],
			'rateValue' => 0,
			'rateSubmissions' => 0
		];
	}

	$batchInsert = $collection->insertMany($documents);
	echo "Inserted " . $batchInsert->getInsertedCount() . ' images <br>';
}