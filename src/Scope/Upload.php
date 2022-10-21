<?php

namespace Meiji\YandexMetrikaOffline\Scope;

use Meiji\YandexMetrikaOffline\Conversion;


/**
 * Class Upload
 *
 * @package Meiji\YandexMetrikaOffline\Scope
 */
class Upload
{
	
	/**
	 *
	 */
	const CLIENT_ID_TYPE_USER = 'USER_ID';
	/**
	 *
	 */
	const CLIENT_ID_TYPE_CLIENT = 'CLIENT_ID';
	/**
	 *
	 */
	const CLIENT_ID_TYPE_YCLID = 'YCLID';
	/**
	 *
	 */
	const SCOPE_PATH = 'upload';
	
	/**
	 * @var \Meiji\YandexMetrikaOffline\Conversion
	 */
	private $conversionInstance;
	/**
	 * @var string
	 */
	private $client_id_type;
	/**
	 * @var int
	 */
	private $counterId;
	/**
	 * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionHeader
	 */
	private $header;
	/**
	 * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator
	 */
	private $conversions;
	/**
	 * @var string
	 */
	private $comment;
	
	/**
	 * Upload constructor.
	 *
	 * @param \Meiji\YandexMetrikaOffline\Conversion $conversionInstance
	 * @param int                                    $counterId
	 * @param string                                 $client_id_type
	 */
	public function __construct(\Meiji\YandexMetrikaOffline\Conversion $conversionInstance, $counterId,
		$client_id_type = self::CLIENT_ID_TYPE_CLIENT)
	{
		
		$this->conversionInstance = $conversionInstance;
		$this->counterId($counterId);
		$this->clientIdType($client_id_type);
		$this->header      = new \Meiji\YandexMetrikaOffline\ValueObject\ConversionHeader($this->client_id_type);
		$this->conversions = new \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator();
	}
	
	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function clientIdType($type)
	{
		
		if ($type == self::CLIENT_ID_TYPE_USER || $type == self::CLIENT_ID_TYPE_CLIENT || $type == self::CLIENT_ID_TYPE_YCLID) {
			$this->client_id_type = $type;
		}
		
		return $this;
	}
	
	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function counterId($id)
	{
		
		$this->counterId = $id;
		
		return $this;
	}
	
	/**
	 * @param string $text
	 *
	 * @return $this
	 */
	public function comment($text)
	{
		
		$this->comment = $text;
		
		return $this;
	}
	
	/**
	 * @param string      $cid
	 * @param string      $target
	 * @param null|string $dateTime
	 * @param null|string $price
	 * @param null|string $currency
	 *
	 * @return \Meiji\YandexMetrikaOffline\ValueObject\Conversion
	 */
	public function addConversion($cid, $target, $dateTime = null, $price = null, $currency = null)
	{
		
		if ($price) {
			$this->header->addUsesColumn('Price');
		}
		
		if ($currency) {
			$this->header->addUsesColumn('Currency');
		}
		
		$conversion = new \Meiji\YandexMetrikaOffline\ValueObject\Conversion($cid, $target, $dateTime, $price,
			$currency);
		
		$this->conversions->append($conversion);
		
		return $conversion;
	}
	
	/**
	 * @return bool|mixed
	 */
	public function send()
	{
		
		$requestUrl = Conversion::API_URL .
					  '/counter/' .
					  $this->counterId .
					  '/offline_conversions/' .
					  self::SCOPE_PATH .
					  '?client_id_type=' .
					  $this->client_id_type;
		
		if ($this->comment) {
			$requestUrl .= '&comment=' . $this->comment;
		}
		
		$result = false;
		
		$response = $this->conversionInstance->getHTTPClient()
			->setUrl($requestUrl)
			->addFile(new \Meiji\YandexMetrikaOffline\ValueObject\ConversionFile($this->header, $this->conversions))
			->requestPost();
		
		if ($response->getStatusCode() === 200) {
			$result = json_decode((string)$response->getBody());
		}
		
		return $result;
	}
	
}
