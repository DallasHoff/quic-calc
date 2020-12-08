<?php
$method = $_SERVER['REQUEST_METHOD'];

$calcRadius = null;
$calcResult = null;
$calcError = null;

if ($method == 'GET' && isset($_GET['radius'])) {
	$calcRadius = floatval($_GET['radius']);
	
	// Call cloud function to calculate area
	// Curl code generated from Postman
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://us-east1-dismob.cloudfunctions.net/circle-area',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => "{
			\"radius\": $calcRadius
		}",
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
	));

	// Get response and close
	$cfResponse = curl_exec($curl);
	$cfResponseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	if ($cfResponse === false) {
		// Curl Error
		$calcError = curl_error($curl);
	} else if ($cfResponseCode !== 200) {
		// Function Error
		$calcError = $cfResponse;
	} else {
		// Success
		$calcResult = $cfResponse;
	}
	curl_close($curl);

}