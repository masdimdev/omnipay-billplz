<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class FetchTransactionRequest extends AbstractRequest
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
        $this->validate(
            'apiKey',
            'signatureKey',
            'transactionReference',
        );

        return [
            'billId' => $this->getTransactionReference(),
        ];
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return FetchTransactionResponse
     */
    public function sendData($data)
    {
        $billId = $data['billId'];

        $endpoint = $this->getEndpoint("bills/{$billId}");
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':'),
        ];

        $httpResponse = $this->httpClient->request('GET', $endpoint, $headers);
        $body = $httpResponse->getBody()->getContents();
        $responseData = json_decode($body, true);

        return $this->response = new FetchTransactionResponse($this, $responseData);
    }
}
