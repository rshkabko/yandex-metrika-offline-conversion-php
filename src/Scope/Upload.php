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
     * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator
     */
    private $conversionTargets;
    /**
     * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator
     */
    private $conversionCalls;
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
        $this->conversionTargets = new \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator($this->client_id_type);
        $this->conversionCalls = new \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator($this->client_id_type);
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

        $conversion_target = new \Meiji\YandexMetrikaOffline\ValueObject\Conversion($cid, $target, $dateTime, $price, $currency);

        $this->conversionTargets->add($conversion_target);

        return $conversion_target;
    }


    /**
     * @param string      $cid
     * @param null|string $dateTime
     * @param null|array $optional_parameters
     *
     * @return \Meiji\YandexMetrikaOffline\ValueObject\ConversionCall
     */
    public function addConversionCall($cid, $dateTime = null, $optional_parameters = null)
    {

        $conversionCall = new \Meiji\YandexMetrikaOffline\ValueObject\ConversionCall($cid, $dateTime, $optional_parameters);

        $this->conversionCalls->add($conversionCall);

        return $conversionCall;
    }

    public function send()
    {

        if(!empty($this->conversionTargets->conversions)) {
            $result['upload'] = $this->requestSend($this->conversionTargets, 'upload');
        }
        if(!empty($this->conversionCalls->conversions)) {
            $result['upload_calls'] = $this->requestSend($this->conversionCalls, 'upload_calls');
        }

        return $result ?? false;

    }

    /**
     * @var \Meiji\YandexMetrikaOffline\ValueObject\ConversionsIterator $conversions
     * @param $scope_path
     * @return bool|mixed
     */
    private function requestSend($conversions, $scope_path)
    {

        $requestUrl = Conversion::API_URL .
            '/counter/' .
            $this->counterId .
            '/offline_conversions/' .
            $scope_path .
            '?client_id_type=' .
            $this->client_id_type;
        if ($this->comment) {
            $requestUrl .= '&comment=' . $this->comment;
        }


        $response = $this->conversionInstance->getHTTPClient()
            ->setUrl($requestUrl)
            ->addFile(new \Meiji\YandexMetrikaOffline\ValueObject\ConversionFile($conversions))
            ->requestPost();

        if ($response->getStatusCode() === 200) {
            $result = json_decode((string)$response->getBody());
        }

        return $result ?? false;
    }

}
