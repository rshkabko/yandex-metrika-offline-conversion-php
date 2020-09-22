<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;


/**
 * Class ConversionsIterator
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class ConversionsIterator extends \ArrayIterator
{
	
	/**
	 * ConversionsIterator constructor.
	 *
	 * @param array $array
	 * @param int   $flags
	 */
	public function __construct(array $array = [], $flags = 0)
	{
		
		parent::__construct($array, $flags);
	}
	
	/**
	 * @param array $columns
	 *
	 * @return string|null
	 */
	public function getString(array $columns = [])
	{
		
		$conversionString = null;
		foreach ($this as $key => $conversion) {
			/** @var \Meiji\YandexMetrikaOffline\ValueObject\Conversion $conversion */
			$conversionString .= $conversion->getString($columns) . (($key == count($this) - 1) ? null : PHP_EOL);
		}
		
		return $conversionString;
	}
	
}
