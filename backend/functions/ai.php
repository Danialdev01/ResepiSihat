<?php

function generateAI($prompt, $ai_api_key){
  // Define the secret key and endpoint
  $secretKey = $ai_api_key;
  $endpoint = 'https://api.groq.com/openai/v1/chat/completions';
  
  // Create the data payload
  $data = [
    'messages' => [
      [
        'role' => 'system',
        'content' => "You act as a Malay Teacher"
      ],
      [
        'role' => 'user',
        'content' => $prompt
      ]
    ],
    'model' => 'llama3-8b-8192'
  ];
  
  // Initialize a cURL session
  $ch = curl_init($endpoint);
  
  // Set the cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $secretKey,
    'Content-Type: application/json'
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  
  // Execute the request
  $response = curl_exec($ch);
  
  // Check for cURL errors
  if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('Curl error: ' . $error);
  }
  
  // Close the cURL session
  curl_close($ch);
  
  // Decode the JSON response
  $responseData = json_decode($response, true);
  
  // Output the response
  header('Content-Type: application/json');
  return json_encode($responseData, JSON_PRETTY_PRINT);

}

?>