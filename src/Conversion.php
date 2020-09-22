<?php

namespace Meiji\YandexMetrikaOffline;

use Meiji\YandexMetrikaOffline\Scope\Upload;


/**
 * Class Conversion
 *
 * @package Meiji\YandexMetrikaOffline
 */
class Conversion
{
	
	/**
	 *
	 */
	const API_URL = 'https://api-metrika.yandex.net/management/v1';
	
	/**
	 *
	 */
	const VERSION = '0.1';
	
	/**
	 * @var string
	 */
	private $oAuthToken;
	
	/**
	 * Conversion constructor.
	 *
	 * @param string $token
	 */
	public function __construct($token)
	{
		
		$this->oAuthToken = $token;
	}
	
	/**
	 * @param null|int $counterId
	 * @param null|string  $client_id_type
	 *
	 * @return \Meiji\YandexMetrikaOffline\Scope\Upload
	 */
	public function upload($counterId = null, $client_id_type = null)
	{
		
		return new Upload($this, $counterId, $client_id_type);
	}
	
	/**
	 * @return \Meiji\YandexMetrikaOffline\Http\Client
	 */
	public function getHTTPClient()
	{
		
		return new Http\Client($this->oAuthToken);
	}
	
}
