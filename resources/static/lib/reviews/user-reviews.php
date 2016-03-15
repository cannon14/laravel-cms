<?php
include_once("../api/ApiClient.php");
include_once("../../affiliate/settings/settings.php");

$cardId = isset($_GET['cardId']) ? $_GET['cardId'] : '';
$page = isset($_GET['pageNum']) ? $_GET['pageNum'] : '';
$order_by = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
$order_dir = isset($_GET['order']) ? $_GET['order'] : '';


$params = array('page' => $page, 'order_by' => $order_by, 'order_dir' => $order_dir);

$resource = 'reviews/' . $cardId;
$api = new ApiClient(REVIEWS_API_URL, REVIEWS_API_USERNAME, REVIEWS_API_PASSWORD, $resource, $params);

if (!$api->isNull()) {

    $response = $api->getResponse();

    echo $response;

} else {

    error_log("API call failure:" . " - Resource: " . $resource . " - Card Id: " . $cardId . " - Params: page=" . $page . ", order_by=" . $order_by . ", order_dir=" . $order_dir);
}