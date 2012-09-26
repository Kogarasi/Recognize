<?php

	require_once( 'recognize_request.php' );

	use Kogarasi\Recognize\RecognizeRequest;

	// for test
	$test_url = 'http://kogarasi.com/kizuna_find/thumbnail/8b2ba89d51c34b833b2fb2098bc6ad35.flv_efsf.png';

	// Load API Key
	$api_key = include_once( 'recognize_apikey.php' );
	echo "API_KEY:$api_key\n\n";

	$recReq = new RecognizeRequest( $api_key );

	$requestJson = json_decode( $recReq->sendRequest( $test_url ) );
	print_r( $requestJson );

	/*
	$sleep_time = 20;
	echo "Wait Time $sleep_time sec ...\n";
	sleep( $sleep_time );
	*/

	$result_url = $requestJson->{'job'}->{'@result-url'};

	$resultJson = null;
	do {

		$resultJson = json_decode( $recReq->getProcess( $result_url ) );
	}while( $resultJson->{'job'}->{'@status'} == 'process' );
	print_r( $resultJson );

	$wordsJson = json_decode( $recReq->getWords( $result_url, 100 ) );
	print_r( $wordsJson );
