<?php

namespace Inc\Base;

class BgFirma
{
    const HASH = 'sha256';

    private $total;
    private $merchantId;
    private $currency;
    private $subtotal;
    private $taxes;
    private $discount;
    private $shipping;
    private $paymentDate;
    private $paymentMethod;
    private $transactionType;
    private $orderId;
    private $successUrl;
    private $failUrl;
    private $domain;
    private $secretToken;

    public function __construct($total, $merchantId, $currency, $subtotal, $taxes, $paymentDate, $paymentMethod, $transactionType, $orderId, $successUrl, $failUrl, $domain, $secretToken, $discount, $shipping)
    {
        $this->total = $total;
        $this->merchantId = $merchantId;
        $this->currency = $currency;
        $this->subtotal = $subtotal;
        $this->taxes = $taxes;
        $this->paymentDate = $paymentDate;
        $this->paymentMethod = $paymentMethod;
        $this->transactionType = $transactionType;
        $this->orderId = $orderId;
        $this->successUrl = $successUrl;
        $this->failUrl = $failUrl;
        $this->domain = $domain;
        $this->secretToken = $secretToken;
        $this->discount = $discount;
        $this->shipping = $shipping;
    }

    public function createHash()
    {
        $values = base64_decode($this->secretToken);
        $secrete = explode('.', $values);
        return hash_hmac(self::HASH, $this->concatElements(), $secrete[0]);
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of merchantId
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Set the value of merchantId
     *
     * @return  self
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of subtotal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set the value of subtotal
     *
     * @return  self
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }


    /**
     * Get the value of taxes
     */
    public function getTaxes()
    {
        return $this->taxes;
    }


    /**
     * Set the value of taxes
     *
     * @return  self
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }


    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }


    /**
     * Get the value of total
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set the value of shipping
     *
     * @return  self
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }


    /**
     * Get the value of paymentDate
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set the value of paymentDate
     *
     * @return  self
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get the value of paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get the value of transactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set the value of transactionType
     *
     * @return  self
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get the value of orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @return  self
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get the value of successUrl
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * Set the value of successUrl
     *
     * @return  self
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * Get the value of failUrl
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * Set the value of failUrl
     *
     * @return  self
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;

        return $this;
    }

    /**
     * Get the value of domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set the value of domain
     *
     * @return  self
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function concatElements()
    {

        return number_format($this->total, 2, '.', '') . $this->merchantId . $this->paymentDate . $this->paymentMethod . $this->transactionType . $this->orderId . $this->successUrl . $this->failUrl . $this->domain;
    }

    /**
     * Get the value of secretToken
     */
    public function getSecretToken()
    {
        return $this->secretToken;
    }

    /**
     * Set the value of secretToken
     *
     * @return  self
     */
    public function setSecretToken($secretToken)
    {
        $this->secretToken = $secretToken;

        return $this;
    }
}
