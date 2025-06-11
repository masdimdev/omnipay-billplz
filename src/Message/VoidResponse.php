<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Common\Message\AbstractResponse;

class VoidResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->data['status_code'] === 200;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->isSuccessful() ? 'Bill deleted successfully' : 'Failed to delete bill';
    }

    /**
     * Raw Response
     *
     * @return null|string A raw response data from the payment gateway
     */
    public function getRawResponse()
    {
        return $this->data['raw'] ?? null;
    }
}
