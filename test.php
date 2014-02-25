#!/usr/bin/env php
<?php
require "vendor/autoload.php";

$url = "http://127.0.0.1:9200";
$limit = 50000;
if( $argc > 1 ) {
	$args = [];
	array_shift($argv);
	foreach ($argv as $arg) {
	  if (preg_match("/^--([^=]+)=(.*)$/",$arg,$reg))
	    $args[$reg[1]] = $reg[2];
	  elseif(preg_match("/^--([a-zA-Z0-9]+)$/",$arg,$reg))
	  	$args[$reg[1]] = true;
	  elseif(preg_match("/^-([a-zA-Z0-9])$/",$arg,$reg))
	    $args[$reg[1]] = true;
	}
	$url = isset($args['url'])?$args['url']:$url;
	$limit = isset($args['limit'])?$args['limit']:$limit;
}

echo "------------------------------------------------------------------------".PHP_EOL;
echo "HTTP Request tester".PHP_EOL;
echo "Perform $limit requests on $url and check performances...".PHP_EOL;

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Guzzle client creation for each call: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	while( $i < $limit ) {
		$client = new Guzzle\Http\Client();
		$client->get($url)->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Guzzle client reuse in all calls: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	$client = new Guzzle\Http\Client();
	while( $i < $limit ) {
		$client->get($url)->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Guzzle request reuse in all calls: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	$client = new Guzzle\Http\Client();
	$request = $client->get($url);
	while( $i < $limit ) {
		$request->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Bee4 HTTP Client with a new client for each call: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	while( $i < $limit ) {
		$client = new Bee4\Http\Client();
		$client->get($url)->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try Bee4 HTTP Client with client reuse: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	$client = new Bee4\Http\Client();
	while( $i < $limit ) {
		$client->get($url)->send();
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try to curl init at each iteration: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	while( $i < $limit ) {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_exec($handle);
		curl_close($handle);
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;

sleep(20);

echo "------------------------------------------------------------------------".PHP_EOL;
echo "Try to curl init with resource reuse: ".PHP_EOL;
$start = microtime(true);
try {
	$i = 0;
	$memory = -1;
	$handle = curl_init();
	while( $i < $limit ) {
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_exec($handle);
		$i++;

		$tmp = memory_get_usage(true);
		$memory = $memory>$tmp?$memory:$tmp;
	}
	curl_close($handle);
	echo "OK - Ended".PHP_EOL;
} catch( \Exception $error ) {
	echo "  ERROR: ".$error->getMessage().PHP_EOL;
	echo "  End at: ".$i.PHP_EOL;
}
echo "Duration: ".number_format(microtime(true) - $start, 2)." sec".PHP_EOL;
echo "Memory: ".number_format(ceil($memory/1000)/1000, 2, '.', ' ')." Mo".PHP_EOL;