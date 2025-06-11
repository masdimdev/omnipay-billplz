<?php

namespace Omnipay\Billplz\Message;

class CompletePurchaseCallbackRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->httpRequest->query->all();
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return CompletePurchaseCallbackResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseCallbackResponse($this, $data);
    }
}
