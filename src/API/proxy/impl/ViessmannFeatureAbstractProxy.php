<?php
/**
 * Created by IntelliJ IDEA.
 * User: clibois
 * Date: 17/03/20
 * Time: 18:06
 */

namespace Viessmann\API\proxy\impl;


use Viessmann\Oauth\ViessmannOauthClientImpl;
use Viessmann\API\proxy\ViessmannFeatureProxy;
use TomPHP\Siren\Entity;
abstract class ViessmannFeatureAbstractProxy implements ViessmannFeatureProxy

{

    protected $viessmannClient;

    public function __construct($viessmannClient)
    {
            $this->viessmannClient = $viessmannClient;
    }

    public function setRawJsonData($feature, $action, $data)
    {
        try {
            $response = json_decode($this->viessmannClient->setData($feature, $action, $data), true);
            if (isset($response["statusCode"])) {
                throw new ViessmannApiException("\n\t Unable to set data for feature" . $feature . " and action " . $action . " and data" . $data . "\n\t Reason: " . $response["message"], 1);
            }
        } catch (TokenResponseException $e) {
            throw new ViessmannApiException("\n\t Unable to set data for feature" . $feature . " and action " . $action . " and data" . $data . " \n\t Reason: " . $e->getMessage(), 1, $e);
        }
    }

}