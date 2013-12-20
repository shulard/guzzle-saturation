#!/usr/bin/env php
<?php
require "vendor/autoload.php";

$url = "http://127.0.0.1:9200";
if( $argc > 1 )
	$url = $argv[1];

echo "------------------------------------------------------------------------".PHP_EOL;
echo "HTTP Request tester".PHP_EOL;
echo "Perform 50000 requests on $url and check performances...".PHP_EOL;

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Guzzle calls: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	while( $i < 50000 ) {
		$client = new Guzzle\Http\Client();
		$client->get($url)->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try to curl init at each iteration: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	while( $i < 50000 ) {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_exec($handle);
		curl_close($handle);
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try to curl init with resource reuse: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	$handle = curl_init();
	while( $i < 50000 ) {
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_exec($handle);
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	curl_close($handle);
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;