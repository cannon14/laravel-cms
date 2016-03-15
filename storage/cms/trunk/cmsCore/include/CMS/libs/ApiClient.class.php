<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/25/14
 * Time: 10:12 AM
 */

require('RestClient.php');

class CMS_libs_ApiClient {

    protected $_client;
    protected $_error;
    protected $_resource;
    protected $_url;
    protected $_isNull;

    public function __construct($url, $uname, $pword, $resource = '', $params = array()) {
        $this->connect($url, $uname, $pword, $resource, $params);
    }

    public function connect($url, $uname, $pword, $resource = '', $params) {

        $this->_isNull = false;

        try {
            $this->_client = RestClient::get($url . $resource, $params, $uname, $pword);
            $this->_resource = $resource;
            $this->_url= $url;
            $this->_params = $params;
        }
        catch (Exception $e) {
            $this->_isNull = true;
        }
    }

    public function isNull() {
        return $this->_isNull;
    }

    public function setUrl($url) {
        $this->_url = $url;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function setParams($params) {
        $this->_params = $params;
    }

    public function getParams() {
        return $this->_params;
    }

    public function getResponseCode() {
        return $this->_client->getResponseCode();
    }

    public function getResponseMessage() {
        return $this->_client->getResponseMessage();
    }

    public function getResponseContentType() {
        return  $this->_client->getResponseContentType();
    }

    public function getResponse() {
        return $this->_client->getResponse();
    }

    public function validateResponse() {
        if($this->getResponseCode() == '200') {
            return true;
        }
        else {
            $this->setError();
        }
        return false;
    }

    public function getResponseAsArray() {
        return json_decode($this->getResponse());
    }

    public function setError() {
        $this->_error = "(".$this->_client->getResponseCode().") ". $this->_client->getResponseMessage();
    }

    public function getError() {
        return $this->_error;
    }

    public function setResource($resource) {
        $this->_resource = $resource;
    }

    public function getResource() {
        return $this->_resource;
    }
} 