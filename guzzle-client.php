<?php
// collect_eggs.php
include __DIR__.'/vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;

$apikey = '';
$accesskeyid = '';
$secretaccesskey = '';
$baseuri = '';

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => $baseuri,
    // You can set any number of default request options.
    //'timeout'  => 20.0
]);

$headers = ['X-Api-Key' => $apikey];
$request = new Request('GET', '/', $headers);

$awscredentials = new Credentials($accesskeyid, $secretaccesskey);

$awssignature = new SignatureV4('apigateway', 'us-east-1');

$request = $awssignature->signRequest($request, $awscredentials);

$response = $client->send($request, ['debug' => true]);

echo $response->getBody();

echo "\n\n";

?>