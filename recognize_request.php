<?php

	namespace Kogarasi\Recognize;

	class RecognizeRequest
	{

		const REQUEST_URL	= "https://recognize.jp/v1/scenery/api/recognition";
		const WORDS_ENDPOINT	= "/words";
		const SEGMENT_ENDPOINT	= "/segment-graphs";

		private $api_key = null;
		private $result_url = null;

		function __construct( $_api_key )
		{
			$this->api_key = $_api_key;
		}

		public function sendRequest( $image_url )
		{
			$param = $this->createParameterString( array(
				'image-url'	=> $image_url,
				'api-key'	=> $this->api_key,
				'dictionary'	=> 'english%2Bjapanese',
				'api-format'	=> 'json',
			));

			$json = file_get_contents( self::REQUEST_URL . '?' . $param );

			return $json;
		}

		public function getProcess( $result_url )
		{
			$param = $this->createParameterString( array(
				'api-key'	=> $this->api_key,
				'api-format'	=> 'json',
			));

			$json = file_get_contents( $result_url . '?' . $param );

			return $json;
		}

		public function getWords( $result_url, $word_num = 5 )
		{

			$words_url = $result_url . self::WORDS_ENDPOINT;
		
			$param = $this->createParameterString( array(
				'api-key'	=> $this->api_key,
				'api-format'	=> 'json',
				'max-result'	=> $word_num,
			));

			$json = file_get_contents( $words_url . '?' . $param );

			return $json;
		}

		public function GetSegment( $result_url )
		{

			$segment_url = $result_url . self::SEGMENT_ENDPOINT;

			$param = $this->createParameterString( array(
				'api-key'	=> $this->api_key,
				'api-format'	=> 'json',
			));

			$json = file_get_contents( $segment_url . '?' . $param );

			return $json;
		}

		private function createParameterString( $param_hash )
		{
			$param_list = array();

			foreach( $param_hash as $key => $val )
			{
				$param_list[] = $key . "=" . $val;
			}

			return join( '&', $param_list );
		}
	}
