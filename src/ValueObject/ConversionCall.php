<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;


/**
 * Class Conversion
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class ConversionCall
{

    /**
     * @var string
     */
    public $ClientId;
    /**
     * @var string
     */
    public $DateTime;
    /**
     * @var string|null
     */
    public $StaticCall = 0;
    /**
     * @var string|null
     */
    public $PhoneNumber;
    /**
     * @var string|null
     */
    public $TalkDuration;
    /**
     * @var string|null
     */
    public $HoldDuration;
    /**
     * @var string|null
     */
    public $CallMissed = 0;
    /**
     * @var string|null
     */
    public $Tag;
    /**
     * @var string|null
     */
    public $FirstTimeCaller;
    /**
     * @var string|null
     */
    public $URL;
    /**
     * @var string|null
     */
    public $Price;
    /**
     * @var string|null
     */
    public $Currency;
    /**
     * @var string|null
     */
    public $CallTrackerURL;

    /**
     * Conversion constructor.
     *
     * @param string      $ClientId
     * @param string|null $DateTime
     * @param array $optional_parameters
     */
    public function __construct($ClientId, $DateTime = null, $optional_parameters = null)
    {

        $optionals = [
            'StaticCall',
            'Price',
            'Currency',
            'PhoneNumber',
            'TalkDuration',
            'HoldDuration',
            'CallMissed',
            'Tag',
            'FirstTimeCaller',
            'URL',
            'CallTrackerURL',
        ];

        $this->ClientId = $ClientId;
        $this->DateTime = $DateTime ?? time();

        foreach ($optionals as $columnName) {
            foreach ($optional_parameters as $key => $optionalVal){
                if(mb_strtolower($columnName) == mb_strtolower($key)){
                    $this->{$columnName} = $optionalVal;
                }
            }
        }

    }


}
