<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;


/**
 * Class Conversion
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class Conversion
{

    /**
     * @var string
     */
    public $ClientId;
    /**
     * @var string
     */
    public $Target;
    /**
     * @var string|null
     */
    public $DateTime;
    /**
     * @var string|null
     */
    public $Price;
    /**
     * @var string|null
     */
    public $Currency;

    /**
     * Conversion constructor.
     *
     * @param string      $ClientId
     * @param string      $Target
     * @param string|null $DateTime
     * @param string|null $Price
     * @param string|null $Currency
     */
    public function __construct($ClientId, $Target, $DateTime = null, $Price = null, $Currency = null)
    {

        $this->ClientId = $ClientId;
        $this->Target   = $Target;
        $this->DateTime = $DateTime ?? time();
        $this->Price    = $Price;
        $this->Currency = $Currency;
    }

}
