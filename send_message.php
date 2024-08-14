#!/usr/bin/env php
<?php
// Load the AWS SDK for PHP
require 'aws.phar';

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

// Create an SQS client
$client = new SqsClient([
    'profile' => 'default',
    'region' => 'us-east-1',
    'version' => '2012-11-05'
]);

$uniqueId = uniqid();

$params = [
    'MessageBody' => "{ \"name:\" \"Jeremy Utley\", \"email\": \"jutley@seedbox.com\"}",
    'QueueUrl' => 'https://sqs.us-east-1.amazonaws.com/678218462727/TestFIFOQueue.fifo',
    'MessageDeduplicationId' => $uniqueId,
];

try {
    $result = $client->sendMessage($params);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
}
