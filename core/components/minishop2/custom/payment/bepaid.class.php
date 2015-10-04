<?php

if (!class_exists('msPaymentInterface')) {
    require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}

class BePaid extends msPaymentHandler implements msPaymentInterface
{
    public $config;

    /** @var modX */
    public $modx;

    /**
     * @param xPDOObject $object
     * @param array $config
     */
    function __construct(xPDOObject $object, $config = [])
    {
        $this->modx = &$object->xpdo;

        $site_url = $this->modx->getOption('site_url');
        $assets_url = $this->modx->getOption('minishop2.assets_url', $config, $this->modx->getOption('assets_url') . 'components/minishop2/');
        $payment_url = $site_url . substr($assets_url, 1) . 'payment/bepaid.php';

        $this->config = array_merge([
            'store_id' => $this->modx->getOption('ms2_payment_bepaid_store_id'),
            'secret_key' => $this->modx->getOption('ms2_payment_bepaid_secret_key'),
            'checkout_url' => $this->modx->getOption('ms2_payment_bepaid_checkout_url', null, 'https://checkout.begateway.com/ctp/api/checkouts'), // ? нужно ли хардкодить
            'language' => $this->modx->getOption('ms2_payment_bepaid_language', null, 'ru'),
            'currency' => $this->modx->getOption('ms2_payment_bepaid_currency', null, 'BYR'),
            'json_response' => false
        ], $config);

        //amount - summ of order        cost in minimal currency units, e.g. $32.45 must be sent as 3245 - usd and cents should be converted to cents
        //currency - currency
        //description - order desc

        //language - list of
//        en - English
//es - Spanish
//tr - Turkish
//de - German
//it - Italian
//ru - Russian
//zh - Chinese
//fr - French
//da - Danish
//sv - Swedish
//no - Norwegian
//fi - Finnish


//        authorization and payment.
        //success_url
        //decline_url
        //fail_url
        //cancel_url
        //notification_url

        // opt tracking_id wtF?
        // opt dynamic_billing_descriptor wtF?

        // opt customer_fields - It controls the input fields for customer details shown at the payment page
        // read_only

        //hidden ?



//        email	Email of your Customer making a purchase at your shop
//first_name	Customer's first name
//last_name	Customer's last name
//address	Customer's billing address
//city	Customer's billing city
//state	Customer's two-letter billing state only if the billing address country is US or CA
//zip	conditionally optional. Customer's billing ZIP or postal code. The parameter is optional if country is from the list.
//If country=US, zip format must be NNNNN or NNNNN-NNNN.
//    phone	Customer's optional phone number
//country	Customer's billing country in ISO 3166-1 Alpha-2 format

    }

    /**
     * @param msOrder $order
     * @return array|string
     */
    public function send(msOrder $order)
    {
        if (!$link = $this->getPaymentToken($order)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ms2::payment::bePaid] Token and redirect url can not be requested.', '', '', __FILE__, __LINE__);
        }

        return $this->success('', ['redirect' => $link]);
    }

    /**
     * @param msOrder $order
     * @return bool|string
     */
    protected function getPaymentToken(msOrder $order)
    {

        $address = $order->getOne('Address'); // все про customer

        // TODO Add real data

        $payload = [
            'checkout' => [
                'transaction_type' => 'payment',
                'settings' => [
                    'success_url' => '',
                    'decline_url' => '',
                    'fail_url' => '',
                    'cancel_url' => '',
                    'notification_url' => '',
                    'language' => $this->config['language'],
                    'customer_fields' => [
                        'read_only' => [],
                        'hidden' => []
                    ]
                ],
                'order' => [
                    'currency' => $this->config['currency'],
                    'amount' => 20000, // рублей
                    'description' => 'Description'
                ],
                'customer' => [
                    'address' => 'Baker street 221b',
                    'country' => 'GB',
                    'city' => 'London',
                    'email' => 'jake@example.com'
                ]
            ]
        ];

        $response = $this->request(
            $this->config['checkout_url'],
            $payload,
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache'
            ],
            [
                $this->config['store_id'],
                $this->config['secret_key']
            ]
        );

        $response = json_decode($response);

        print_r($response);

        exit;

        if (isset($response['checkout']) && isset($response['checkout']['redirect_url'])) {
            return $response['checkout']['redirect_url'];
        }

        return false;
    }

    /**
     * @param $url
     * @param $payload
     * @param array $headers
     * @param array $auth
     * @return mixed
     */
    protected function request($url, $payload, $headers = [], $auth = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function ($key, $value) {
            return join(': ', [$key, $value]);
        }, array_keys($headers), $headers));

        curl_setopt($ch, CURLOPT_USERPWD, join(':', $auth));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($response === false) {
            $this->modx->log(
                modX::LOG_LEVEL_ERROR,
                '[ms2::payment::bePaid] CURL Error, can not process request via path "' . $url . '". Error info: ' . $error,
                '', '', __FILE__, __LINE__
            );
        }

        return $response;
    }

    /**
     * @param msOrder $order
     * @param array $params
     * @return void
     */
    public function receive(msOrder $order, $params = [])
    {
        switch ($params['action']) {
            case 'success':
                if (empty($params['wsb_tid'])) {
                    $this->paymentError("Could not get transaction id. Process stopped.");
                }

                $transaction_id = $params['wsb_tid'];
                $postdata = '*API=&API_XML_REQUEST=' . urlencode('<?xml version="1.0" encoding="ISO-8859-1"?><wsb_api_request><command>get_transaction</command><authorization><username>' . $this->config['login'] . '</username><password>' . md5($this->config['password']) . '</password></authorization><fields><transaction_id>' . $transaction_id . '</transaction_id></fields></wsb_api_request>');

                $curl = curl_init($this->config['gate_url']);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $response = curl_exec($curl);
                curl_close($curl);

                $xml = simplexml_load_string($response);

                if ((string)$xml->status == 'success') {
                    $fields = (array)$xml->fields;

                    $crc = md5(
                        $fields['transaction_id']
                        . $fields['batch_timestamp']
                        . $fields['currency_id']
                        . $fields['amount']
                        . $fields['payment_method']
                        . $fields['payment_type']
                        . $fields['order_id']
                        . $fields['rrn']
                        . $this->config['secret']
                    );

                    if ($crc == $fields['wsb_signature'] && in_array($fields['payment_type'], array(1, 4))) {
                        $miniShop2 = $this->modx->getService('miniShop2');
                        @$this->modx->context->key = 'mgr';
                        $miniShop2->changeOrderStatus($order->get('id'), 2);
                    } else {
                        $this->paymentError('Transaction with id ' . $transaction_id . ' is not valid.');
                    }
                } else {
                    $this->paymentError('Could not check transaction with id ' . $transaction_id);
                }
                break;
            case 'notify':
                $crc = md5(
                    $params['batch_timestamp']
                    . $params['currency_id']
                    . $params['amount']
                    . $params['payment_method']
                    . $params['order_id']
                    . $params['site_order_id']
                    . $params['transaction_id']
                    . $params['payment_type']
                    . $params['rrn']
                    . $this->config['secret']
                );
                if ($crc == $params['wsb_signature'] && in_array($params['payment_type'], array(1, 4))) {
                    $miniShop2 = $this->modx->getService('miniShop2');
                    @$this->modx->context->key = 'mgr';
                    $miniShop2->changeOrderStatus($order->get('id'), 2);
                    header("HTTP/1.0 200 OK");
                    exit;
                } else {
                    $this->paymentError('Transaction with id ' . $params['transaction_id'] . ' is not valid.');
                }
                break;
            case 'cancel':
                $miniShop2 = $this->modx->getService('miniShop2');
                @$this->modx->context->key = 'mgr';
                $miniShop2->changeOrderStatus($order->get('id'), 4);
                break;
        }
    }

    /**
     * @param $text
     * @param array $request
     */
    public function paymentError($text, $request = [])
    {
        $this->modx->log(modX::LOG_LEVEL_ERROR, '[miniShop2:bePaid] ' . $text . ', request: ' . print_r($request, 1));
        header("HTTP/1.0 400 Bad Request");

        die('ERROR: ' . $text);
    }
}
