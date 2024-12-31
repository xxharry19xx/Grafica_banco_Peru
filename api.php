<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$startYear = 1995;
$endYear = 2020;
$countryCode = "PER";
$baseUrl = "https://api.worldbank.org/pip/v1/pip";
$dataPoints = [];

function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log("Error en cURL: " . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

for ($year = $startYear; $year <= $endYear; $year++) {
    $url = "$baseUrl?country=$countryCode&year=$year";
    $response = fetchData($url);
    $jsonData = json_decode($response, true);

    if (!empty($jsonData[0]['headcount'])) {
        $dataPoints[] = [$year, $jsonData[0]['headcount'] * 100];
    } else {
        error_log("No se encontró 'headcount' para el año $year.");
    }
}

echo json_encode($dataPoints);
?>
