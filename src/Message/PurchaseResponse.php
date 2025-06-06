<?php

namespace Omnipay\Billplz\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isError(): bool
    {
        return isset($this->data['error']);
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect(): bool
    {
        return !$this->isError() && !empty($this->getRedirectUrl());
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->data['url'] ?? '';
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod(): string
    {
        return 'GET';
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
    public function getMessage(): ?string
    {
        if ($this->isError()) {
            if (isset($this->data['error']['message'])) {
                return implode(', ', $this->data['error']['message']);
            }

            return 'Unknown error from Billplz.';
        }

        return null;
    }
}
