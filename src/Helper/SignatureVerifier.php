<?php

namespace Omnipay\Billplz\Helper;

class SignatureVerifier
{
    public static function verify(array $data, string $signature, string $secretKey): bool
    {
        if (empty($data) || empty($signature) || empty($secretKey)) {
            return false;
        }

        $flattened = self::flattenArray($data);

        $computedSignature = hash_hmac('sha256', $flattened, $secretKey);

        return hash_equals($signature, $computedSignature);
    }

    private static function flattenArray(array $data, string $prefix = ''): string
    {
        $elements = [];

        foreach ($data as $key => $value) {
            $fullKey = $prefix . $key;

            if (is_array($value)) {
                // Handle associative and indexed arrays
                $isAssoc = array_keys($value) !== range(0, count($value) - 1);
                if ($isAssoc) {
                    $elements = array_merge($elements, explode('|', self::flattenArray($value, $fullKey)));
                } else {
                    foreach ($value as $item) {
                        if (is_array($item)) {
                            $elements = array_merge($elements, explode('|', self::flattenArray($item, $fullKey)));
                        } else {
                            $elements[] = $fullKey . $item;
                        }
                    }
                }
            } else {
                $elements[] = $fullKey . $value;
            }
        }

        // Sort the elements case-insensitively
        usort($elements, 'strcasecmp');

        return implode('|', $elements);
    }
}