# Billplz Omnipay Driver

**Important:** This implementation is based on the **Billplz API V3**. Ensure compatibility with your integration requirements and verify if this version aligns with the gateway setup provided by Billplz.

An Omnipay driver for integrating with the Billplz payment gateway, supporting features such as `purchase`, `completePurchase`, and `fetchTransaction`.

## Getting Started

Install via Composer:

```bash
composer require masdimdev/omnipay-billplz
```

Set up the gateway:

```php
$gateway = Omnipay::create('Billplz');
$gateway->setApiKey('your-billplz-api-key');
$gateway->setSignatureKey('billplz-x-signature-key');
$gateway->setCollectionId('collection-id');
$gateway->setTestMode(false); // Default: false, set to true if in test/sandbox mode
```

## Available Methods

### `purchase`

Redirects the user to the Billplz payment page for completing a transaction.

**Required Data**

| Parameter       | Type      | Description                                                                                                                         |
| --------------- | --------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| `amount`        | `integer` | A positive integer in the smallest currency unit (e.g., 100 = RM1.00).                                                              |
| `description`   | `string`  | The bill's description. Will be displayed on bill template. (Max 200 characters)                                                    |
| `name`          | `string`  | Bill recipient's full name. Useful for identification. (Max 255 characters)                                                         |
| `email`         | `string`  | Recipient's email address. **Required if `mobile` is not provided**.                                                                |
| `mobile`        | `string`  | Recipient's mobile number. **Required if `email` is not provided**. Include country code, no spaces or dashes (e.g., +60123456789). |
| `callback_url`  | `string`  | Webhook URL to be called after transaction completion. It will `POST` a Bill object.                                                |

**Optional Data**

| Parameter           | Type      | Description                                                                                                                                 |
| ------------------- | --------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| `due_at`            | `string`  | Due date for the bill in `YYYY-MM-DD` format. Default is today. Year range is 19xx to 2xxx. Informational only, does not affect payability. |
| `redirect_url`      | `string`  | URL to redirect customer after payment. Performs a `GET` with bill's status and ID.                                                         |
| `deliver`           | `boolean` | Whether to send email and SMS (if `mobile` is provided). Default is `false`. SMS charges may apply.                                         |
| `reference_1_label` | `string`  | Label #1 to reconcile payments. Default is "Reference 1". (Max 20 characters)                                                               |
| `reference_1`       | `string`  | Value for `reference_1_label`. (Max 120 characters)                                                                                         |
| `reference_2_label` | `string`  | Label #2 to reconcile payments. Default is "Reference 2". (Max 20 characters)                                                               |
| `reference_2`       | `string`  | Value for `reference_2_label`. (Max 120 characters)                                                                                         |

#### Example

```php
$response = $gateway->purchase([
    'amount'        => 100,
    'description'   => 'Test Product',
    'name'          => 'John Doe',
    'email'         => 'john@example.com',
    'callback_url'  => 'https://your-app.com/callback-url',
    'redirect_url'  => 'https://your-app.com/redirect-url',
])->send();

if ($response->isRedirect()) {
    $response->redirect(); // Redirect to Billplz payment page
}
```

#### Response Methods

- `isError()`: Indicates if the response is an error.
- `isRedirect()`: Indicates if the response is not error and contains a redirection URL (Billplz payment page).
- `redirect()`: Redirect to Billplz payment page.
- `getRedirectUrl()`: Gets the redirect destination url.
- `getRedirectMethod()`: Get the required redirect method (always `GET`).
- `getTransactionReference()`: Returns Billplz's Bill ID.

### `completePurchase`

Verifies the transaction status by handling the response from Billplz after the user completes payment.

#### Example

```php
$response = $gateway->completePurchase()->send();

if ($response->isSuccessful()) {
    echo 'Transaction successful';
} else {
    echo 'Transaction failed';
}
```

#### Response Methods

- `isSuccessful()`: Aliases `isPaid()`.
- `isPaid()`: Indicates if the transaction was successfully paid.
- `getPaidAt()`: Returns the date and time when payment was made.
- `isSignatureValid()`: Indicates if the response signature was valid.
- `getTransactionReference()`: Returns Billplz's Bill ID.
- `getData()`: Returns the Billplz transaction response.

### `fetchTransaction`

Retrieves detailed information about specific transaction.

**Required Data**

| Parameter | Type        | Description                     |
|-----------| ----------- |---------------------------------|
| `bill_id` | `string`  | Bill ID or tansaction reference |

#### Example

```php
$response = $gateway->fetchTransaction(['bill_id' => '8X0Iyzaw'])->send();

if ($response->isSuccessful()) {
    echo 'Transaction successful';
} else {
    echo 'Transaction failed: ' . $response->getMessage();
}
```

#### Response Methods

- `isSuccessful()`: Aliases `isPaid()`.
- `isPaid()`: Indicates if the transaction was successfully paid.
- `getPaidAt()`: Returns the date and time when payment was made.
- `getTransactionReference()`: Returns Billplz's Bill ID.
- `getData()`: Returns the Billplz transaction response.

## License

This package is open-source software licensed under the MIT License.
