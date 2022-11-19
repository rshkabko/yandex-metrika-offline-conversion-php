<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;

use Meiji\YandexMetrikaOffline\Scope\Upload;
/**
 * Class ConversionsIterator
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class ConversionsIterator
{

    /**
     * @var null
     */
    public $conversions;
    /**
     * @var null
     */
    public $usesColumns;
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
     * @var null
     */
    private $ClientIdType;


    /**
     * ConversionsIterator constructor.
     *
     * @param $client_id_type
     */
    public function __construct(&$client_id_type = null)
    {
        $this->ClientIdType = &$client_id_type;
    }


    /**
     * @var \Meiji\YandexMetrikaOffline\ValueObject\Conversion|\Meiji\YandexMetrikaOffline\ValueObject\ConversionCall $conversion
     */
    public function add($conversion)
    {

        $this->conversions[] = $conversion;

        foreach ($conversion as $key => $value) {
            $this->usesColumns[$key] =
                (!empty($this->usesColumns[$key]) || !empty($value));
        }

    }

    /**
     * @return string
     */
    public function getStringHeaders()
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

        $headerString = '';
        foreach ($this->usesColumns as $columnName => $uses) {
            if($uses) $headerString .= "," . $columnName;
        }

        $headerString = str_replace(",ClientId", $typeColumnName, $headerString);

        return $headerString;
    }

    /**
     *
     * @return string|null
     */
    public function getStringContent()
    {

        $ContentString = '';
        foreach ($this->conversions as $conversion) {
            foreach ($this->usesColumns as $columnName => $uses) {
                if ($uses) {
                    $ContentString .= $conversion->{$columnName} ?? '';
                    $ContentString .= ',';
                }
            }
            $ContentString = mb_substr($ContentString, 0, -1);
            $ContentString .= PHP_EOL;
        }
        return $ContentString;
    }

}
