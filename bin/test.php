<?php

if (!function_exists('curl_init')) {
    die('Sorry cURL is not installed!');
}

$url = 'http://127.0.0.1:8000/app.php/get?method=get';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$getoutput = curl_exec($ch);
curl_close($ch);

$url = 'http://127.0.0.1:8000/app.php/post';
$post_data = array(
    'id' => '156',
    'name' => 'alice',
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$postoutput = curl_exec($ch);
curl_close($ch);

echo $getoutput;
echo $postoutput;
