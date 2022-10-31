<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;


use Meiji\YandexMetrikaOffline\Scope\Upload;


/**
 * Class ConversionHeader
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class ConversionHeader
{
	
	/**
	 *
	 */
	const CLIENT_ID_TYPE_USER_COLUMN_NAME  = 'UserId';
	/**
	 *
	 */
	const CLIENT_ID_TYPE_CLIENT_COLUMN_NAME = 'ClientId';
	/**
	 *
	 */
	const CLIENT_ID_TYPE_YCLID_COLUMN_NAME = 'Yclid';

	/**
	 * @var array
	 */
	private static $availableColumns = ['UserId', 'ClientId', 'Yclid', 'Target', 'DateTime', 'Price', 'Currency'];
	
	/**
	 * @var null
	 */
	private $ClientIdType;
	/**
	 * @var
	 */
	private $usesColumns;
	
	/**
	 * ConversionHeader constructor.
	 *
	 * @param null $client_id_type
	 */
	public function __construct(&$client_id_type = null)
	{
		
		$this->ClientIdType = &$client_id_type;
		
		$this->setDefaultUsesColumns();
	}
	
	/**
	 * @return string
	 */
	public function getString()
	{
		switch ($this->ClientIdType) {
			case Upload::CLIENT_ID_TYPE_USER:
				$typeColumnName = self::CLIENT_ID_TYPE_USER_COLUMN_NAME;
				break;

			default:
			case Upload::CLIENT_ID_TYPE_CLIENT:
				$typeColumnName = self::CLIENT_ID_TYPE_CLIENT_COLUMN_NAME;
				break;

			case Upload::CLIENT_ID_TYPE_YCLID:
				$typeColumnName = self::CLIENT_ID_TYPE_YCLID_COLUMN_NAME;
				break;
		}
		
		$headerString = $typeColumnName;
		foreach ($this->usesColumns as $columnName) {
			$headerString .= "," . $columnName;
		}
		
		return $headerString;
	}
	
	/**
	 *
	 */
	public function setDefaultUsesColumns()
	{
		
		$this->usesColumns = [];
		$this->addUsesColumn('Target');
		$this->addUsesColumn('DateTime');
	}
	
	/**
	 * @param $name
	 */
	public function addUsesColumn($name)
	{
		
		if (in_array($name, self::$availableColumns)) {
			$this->usesColumns[] = $name;
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getUsesColumns()
	{
		
		return $this->usesColumns;
	}
	
	/**
	 * @return int
	 */
	public function count()
	{
		
		return count($this->usesColumns) + 1;
	}
	
}
