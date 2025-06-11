<?php

namespace Omnipay\Billplz;

use Omnipay\Billplz\Message\CompletePurchaseCallbackRequest;
use Omnipay\Billplz\Message\FetchTransactionRequest;
use Omnipay\Billplz\Message\CompletePurchaseRequest;
use Omnipay\Billplz\Message\PurchaseRequest;
use Omnipay\Billplz\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface refund(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'billplz';
    }

    public function getDefaultParameters(): array
    {
        return [
            'apiKey' => '',
            'signatureKey' => '',
            'collectionId' => '',
            'testMode' => false,
        ];
    }

    public function setApiKey($value): Gateway
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setSignatureKey($value): Gateway
    {
        return $this->setParameter('signatureKey', $value);
    }

    public function getSignatureKey(): Gateway
    {
        return $this->getParameter('signatureKey');
    }

    public function setCollectionId($value): Gateway
    {
        return $this->setParameter('collectionId', $value);
    }

    public function getCollectionId(): Gateway
    {
        return $this->getParameter('collectionId');
    }

    public function purchase(array $options = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function completePurchaseCallback(array $options = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseCallbackRequest::class, $options);
    }

    public function fetchTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    public function void(array $options = []): RequestInterface
    {
        return $this->createRequest(VoidRequest::class, $options);
    }
}
