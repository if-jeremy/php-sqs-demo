#!/usr/bin/env php
<?php
// Load the AWS SDK for PHP
require 'aws.phar';

use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;
use Aws\Sqs\SqsClient;

$provider = CredentialProvider::ecsCredentials();
$memoizedCredentials = CredentialProvider::memoize($provider);

// Create an SQS client
$client = new SqsClient([
    'region' => 'us-east-1',
    'version' => '2012-11-05',
    'credentials' => $memoizedCredentials
]);

$uniqueId = uniqid();

$params = [
    'MessageBody' => "{ \"name:\" \"Jeremy Utley\", \"email\": \"jutley@seedbox.com\"}",
    'QueueUrl' => 'https://sqs.us-east-1.amazonaws.com/678218462727/TestFIFOQueue.fifo',
    'MessageDeduplicationId' => $uniqueId,
    'MessageGroupId' => 'foo'
];

try {
    $result = $client->sendMessage($params);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
}
