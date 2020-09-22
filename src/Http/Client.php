<?php

namespace Meiji\YandexMetrikaOffline\Http;

use Meiji\YandexMetrikaOffline\Conversion;


/**
 * Class Client
 *
 * @package Meiji\YandexMetrikaOffline\Http
 */
class Client
{
	
	/**
	 * @var string
	 */
	private $token;
	/**
	 * @var string
	 */
	private $contentType;
	/**
	 * @var array
	 */
	private $multipart;
	/**
	 * @var string
	 */
	private $url;
	
	/**
	 * Client constructor.
	 *
	 * @param string $token
	 */
	public function __construct($token)
	{
		
		$this->token = $token;
	}
	
	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl($url)
	{
		
		$this->url = $url;
		
		return $this;
	}
	
	/**
	 * @param \Meiji\YandexMetrikaOffline\ValueObject\ConversionFile $file
	 *
	 * @return $this
	 */
	public function addFile(\Meiji\YandexMetrikaOffline\ValueObject\ConversionFile $file)
	{
		
		$this->contentType = 'multipart/form-data';
		$this->multipart[] = $file->getArray();
		
		return $this;
	}
	
	/**
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function requestPost()
	{
		
		$guzzle = new \GuzzleHttp\Client([
			'headers' => [
				'Authorization' => 'OAuth ' . $this->token,
				'User-Agent'    => 'MeijiYandexMetrikaOffline/' . Conversion::VERSION,
				'Content-Type'  => $this->contentType
			]
		]);
		
		$optionsArray = [];
		
		if (!empty($this->multipart)) {
			$optionsArray['multipart'] = $this->multipart;
		}
		
		$response = $guzzle->post($this->url, $optionsArray);
		
		return $response;
	}
	
}
