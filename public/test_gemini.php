<?php
// Test Gemini API key directly from public directory
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$apiKey = config('services.gemini.api_key');
$model = config('services.gemini.model', 'gemini-2.0-flash');

echo "Configured API Key: " . substr($apiKey, 0, 8) . "...\n";
echo "Configured Model: $model\n\n";

// Try gemini-2.0-flash
echo "Testing gemini-2.0-flash:\n";
testModel($apiKey, 'gemini-2.0-flash');

// Try gemini-1.5-flash
echo "\nTesting gemini-1.5-flash:\n";
testModel($apiKey, 'gemini-1.5-flash');

function testModel($apiKey, $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Hello, reply with one word: OK.']
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "HTTP Code: $httpCode\n";
    echo "Response: $response\n";
}
