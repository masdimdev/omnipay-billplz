<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    private string $productionEndpointV3 = "https://www.billplz.com/api/v3/";
    private string $sandboxEndpointV3 = "https://www.billplz-sandbox.com/api/v3/";

    protected function getEndpoint(string $path = ''): string
    {
        $endpoint = $this->getTestMode() ? $this->sandboxEndpointV3 : $this->productionEndpointV3;

        return $endpoint . $path;
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setSignatureKey($value)
    {
        return $this->setParameter('signatureKey', $value);
    }

    public function getSignatureKey()
    {
        return $this->getParameter('signatureKey');
    }

    public function setCollectionId($value)
    {
        return $this->setParameter('collectionId', $value);
    }

    public function getCollectionId()
    {
        return $this->getParameter('collectionId');
    }

    public function getName()
    {
        return $this->getParameter('name');
    }

    public function setName($value): AbstractRequest
    {
        return $this->setParameter('name', $value);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value): AbstractRequest
    {
        return $this->setParameter('email', $value);
    }

    public function getMobile()
    {
        return $this->getParameter('mobile');
    }

    public function setMobile($value): AbstractRequest
    {
        return $this->setParameter('mobile', $value);
    }

    public function getDueAt()
    {
        return $this->getParameter('due_at');
    }

    public function setDueAt($value): AbstractRequest
    {
        return $this->setParameter('due_at', $value);
    }

    public function getDeliver()
    {
        return $this->getParameter('deliver');
    }

    public function setDeliver($value): AbstractRequest
    {
        return $this->setParameter('deliver', $value);
    }

    public function getReference_1Label()
    {
        return $this->getParameter('reference_1_label');
    }

    public function setReference_1Label($value): AbstractRequest
    {
        return $this->setParameter('reference_1_label', $value);
    }

    public function getReference_1()
    {
        return $this->getParameter('reference_1');
    }

    public function setReference_1($value): AbstractRequest
    {
        return $this->setParameter('reference_1', $value);
    }

    public function getReference_2Label()
    {
        return $this->getParameter('reference_2_label');
    }

    public function setReference_2Label($value): AbstractRequest
    {
        return $this->setParameter('reference_2_label', $value);
    }

    public function getReference_2()
    {
        return $this->getParameter('reference_2');
    }

    public function setReference_2($value): AbstractRequest
    {
        return $this->setParameter('reference_2', $value);
    }

    public function getCallbackUrl(): string
    {
        return $this->getNotifyUrl();
    }

    public function setCallbackUrl($value): AbstractRequest
    {
        return $this->setNotifyUrl($value);
    }

    public function getRedirectUrl(): string
    {
        return $this->getReturnUrl();
    }

    public function setRedirectUrl($value): AbstractRequest
    {
        return $this->setReturnUrl($value);
    }

    public function getBillId(): string
    {
        return $this->getTransactionReference();
    }

    public function setBillId($value): AbstractRequest
    {
        return $this->setTransactionReference($value);
    }
}
