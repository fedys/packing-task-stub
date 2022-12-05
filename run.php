<?php

use App\Application;
use App\Calculator\ApiCalculator;
use App\Calculator\CompositeCalculator;
use App\Calculator\ExistingCalculator;
use App\Calculator\FallbackCalculator;
use App\Packaging\Api;
use App\Packaging\ProductListParser;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

/** @var EntityManager $entityManager */
$entityManager = require __DIR__ . '/src/bootstrap.php';

$request = new Request('POST', new Uri('http://localhost/pack'), ['Content-Type' => 'application/json'], $argv[1]);

$apiClient = new Client([
    'base_uri' => getenv('API_BASE_URI') ?: 'https://global-api.3dbinpacking.com',
    'timeout'  => 10,
]);
$api = new Api($apiClient, getenv('API_USERNAME') ?: '_username_', getenv('API_KEY') ?: '_key_');

$calculator = new CompositeCalculator();
$calculator->add(new ExistingCalculator($entityManager));
$calculator->add(new ApiCalculator($entityManager, $api));
$calculator->add(new FallbackCalculator());

$application = new Application($entityManager, New ProductListParser(), $calculator);
$response = $application->run($request);

echo "<<< In:\n" . Message::toString($request) . "\n\n";
echo ">>> Out:\n" . Message::toString($response) . "\n\n";
