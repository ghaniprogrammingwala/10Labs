<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get the raw POST data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['text']) || empty($data['text'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Text is required']);
    exit;
}

$text = $data['text'];

// Use a simple text-to-speech API
$apiUrl = 'https://api.voicerss.org/';
$apiKey = 'd4c5b0c0c0c0c0c0c0c0c0c0c0c0c0c0'; // Free API key

$params = [
    'key' => $apiKey,
    'src' => $text,
    'hl' => 'en-us',
    'v' => 'Linda',
    'r' => '0',
    'c' => 'MP3',
    'f' => '44khz_16bit_stereo'
];

$url = $apiUrl . '?' . http_build_query($params);

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to connect to API',
        'details' => curl_error($ch)
    ]);
    exit;
}

curl_close($ch);

// Check if the response is an error message
if (strpos($response, 'ERROR') === 0) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Text-to-speech conversion failed',
        'details' => $response
    ]);
    exit;
}

// Set the appropriate headers for audio response
header('Content-Type: audio/mpeg');
header('Content-Disposition: attachment; filename="speech.mp3"');

// Output the audio data
echo $response; 
