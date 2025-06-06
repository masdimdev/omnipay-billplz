<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $args = [
            'apiKey',
            'signatureKey',
            'collectionId',
            'name',
            'amount',
            'description',
            'notifyUrl',
        ];

        if (empty($this->getEmail())) {
            $args[] = 'mobile';
        }

        if (empty($this->getMobile())) {
            $args[] = 'email';
        }

        $this->validate(...$args);

        return [
            'collection_id' => $this->getCollectionId(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'name' => $this->getName(),
            'amount' => $this->getAmount(),
            'description' => $this->getDescription(),
            'callback_url' => $this->getNotifyUrl(),
            'redirect_url' => $this->getReturnUrl(),
            'reference_1_label' => $this->getReference_1Label(),
            'reference_1' => $this->getReference_1(),
            'reference_2_label' => $this->getReference_2Label(),
            'reference_2' => $this->getReference_2(),
        ];
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $headers = [
            'Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':'),
        ];

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint('bills'),
            $headers,
            http_build_query($data)
        );

        $responseBody = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseBody);
    }
}
