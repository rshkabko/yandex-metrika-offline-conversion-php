<?php

namespace Meiji\YandexMetrikaOffline\ValueObject;

/**
 * Class ConversionFile
 *
 * @package Meiji\YandexMetrikaOffline\ValueObject
 */
class ConversionFile
{

    /**
     * @var string
     */
    private $name     = 'file';
    /**
     * @var string
     */
    private $filename = 'data.csv';
    /**
     * @var array
     */
    private $headers;
    /**
     * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator
     */
    private $dataConversions;

    /**
     * ConversionFile constructor.
     *
     * @param \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator $dataConversions
     */
    public function __construct(\Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator $dataConversions)
    {

        $this->dataConversions = $dataConversions;

        $this->headers = [
            'Content-Disposition' => 'form-data; name="' . $this->name . '"; filename="' . $this->filename . '"',
            'Content-Type'        => 'text/csv',
            'Content-Length'      => ''
        ];
    }

    /**
     * @return array
     */
    public function getArray()
    {

        return [
            'name'     => $this->name,
            'filename' => $this->filename,
            'contents' => $this->getFileContent(),
            'headers'  => $this->headers
        ];
    }

    /**
     * @return string
     */
    public function getFileContent()
    {

        $fileContent = $this->dataConversions->getStringHeaders() . PHP_EOL;
        $fileContent .= $this->dataConversions->getStringContent();

        return $fileContent;
    }

}
