#!/usr/bin/env php
<?php
// Load the AWS SDK for PHP
require 'aws.phar';

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

$queueUrl = "https://sqs.us-east-1.amazonaws.com/678218462727/TestFIFOQueue.fifo";

$client = new SqsClient([
    'profile' => 'default',
    'region' => 'us-east-1',
    'version' => '2012-11-05'
]);

try {
    $result = $client->receiveMessage([
        'MaxNumberOfMessages' => 1,
        'QueueUrl' => $queueUrl, // REQUIRED
        'WaitTimeSeconds' => 20,
    ]);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
}
