<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Billplz\Helper\SignatureVerifier;
use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseCallbackResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->isPaid();
    }

    /**
     * Check if the payment status is marked as paid.
     *
     * @return bool True if 'paid' is 'true', false otherwise.
     */
    public function isPaid(): bool
    {
        return isset($this->data['paid']) && filter_var($this->data['paid'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the date and time when payment was made.
     *
     * @return string|null Payment timestamp or null if unavailable.
     */
    public function getPaidAt(): ?string
    {
        return $this->data['paid_at'] ?? null;
    }

    /**
     * Is the response signature valid?
     *
     * @return boolean
     */
    public function isSignatureValid(): bool
    {
        $data = $this->data;

        $signature = $data['x_signature'] ?? null;

        if (!$signature) {
            return false;
        }

        unset($data['x_signature']);

        return SignatureVerifier::verify($data, $signature, $this->getRequest()->getSignatureKey());
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference(): ?string
    {
        return $this->data['id'] ?? null;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->isPaid() ? 'Payment successful via redirect' : 'Payment was not completed';
    }
}
