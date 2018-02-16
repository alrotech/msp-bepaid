<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Ivan Klimchuk <ivan@klimchuk.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if (!class_exists('msPaymentInterface')) {
    $path = dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
    if (is_readable($path)) {
        require_once $path;
    }
}

/**
 * Class BePaid
 */
class BePaid extends msPaymentHandler implements msPaymentInterface
{
    const PREFIX = 'ms2_payment_bepaid';

    const OPTION_STORE_ID = 'store_id';
    const OPTION_SECRET_KEY = 'secret_key';
    const OPTION_CHECKOUT_URL = 'checkout_url';
    const OPTION_LANGUAGE = 'language';
    const OPTION_COUNTRY = 'country';
    const OPTION_READONLY_FIELDS = 'readonly_fields';
    const OPTION_HIDDEN_FIELDS = 'hidden_fields';
    const OPTION_CURRENCY = 'currency';
    const OPTION_TEST_MODE = 'test_mode';
    const OPTION_SUCCESS_STATUS = 'success_status';
    const OPTION_FAILURE_STATUS = 'failure_status';
    const OPTION_SUCCESS_PAGE = 'success_page';
    const OPTION_FAILURE_PAGE = 'failure_page';
    const OPTION_API_VERSION = 'api_version';
    const OPTION_PAYMENT_TYPES = 'payment_types';
    const OPTION_ERIP_SERVICE_ID = 'erip_service_id';

    public $config = [];

    /**
     * BePaid constructor.
     * @param xPDOObject $object
     * @param array $config
     */
    public function __construct(xPDOObject $object, array $config = [])
    {
        parent::__construct($object, $config);

        $this->config = $config;
    }

    /**
     * @param msPayment $payment
     * @throws ReflectionException
     * @return void
     */
    protected function configure(msPayment $payment)
    {
        $config = [];

        if (!is_subclass_of(get_class($payment), msPayment::class)) {
            $this->log('Passed object is not a payment object');
        }

        $properties = $payment->get('properties') ?: [];

        $reflection = new ReflectionClass(self::class);
        foreach ($reflection->getConstants() as $constant => $value) {
            if ($constant === 'PREFIX') { continue; }
            $key = self::PREFIX . '_' . $value;
            $config[$value] = array_key_exists($key, $properties)
                ? $properties[$key]
                : $this->modx->getOption($key, null);
        }

        $config['payment_url'] = join('/', [
            rtrim($this->modx->getOption('site_url'), '/'),
            ltrim($this->modx->getOption('minishop2.assets_url', $config, $this->modx->getOption('assets_url') . 'components/minishop2'), '/'),
            'payment/bepaid.php'
        ]);

        $config = array_merge($config, $this->config);

        $read_only = $config[self::OPTION_READONLY_FIELDS];
        $read_only = $read_only ? explode(',', $read_only) : null;
        if ($read_only) {
            $config['customer_fields']['read_only'] = $read_only;
        }

        $hidden = $config[self::OPTION_HIDDEN_FIELDS];
        $hidden = $hidden ? explode(',', $hidden) : null;
        if ($hidden) {
            $config['customer_fields']['hidden'] = $hidden;
        }

        if (!in_array($config[self::OPTION_LANGUAGE],
            ['en', 'es', 'tr', 'de', 'it', 'ru', 'zh', 'fr', 'da', 'sv', 'no', 'fi']
        )) {
            // english by default in other unimaginable cases
            $config[self::OPTION_LANGUAGE] = 'en';
        }

        $this->config = $config;
    }

    /**
     * @param msOrder $order
     * @return array|string
     * @throws ReflectionException
     */
    public function send(msOrder $order)
    {
        if (!$link = $this->getPaymentToken($order)) {
            return $this->error('Token and redirect url can not be requested. Look at error log.');
        }

        return $this->success('', ['redirect' => $link]);
    }

    /**
     * @param msOrder $order
     * @return bool|string
     * @throws ReflectionException
     */
    protected function getPaymentToken(msOrder $order)
    {
        /** @var msPayment $payment */
        $payment = $order->getOne('Payment');
        /** @var msOrderAddress $address */
        $address = $order->getOne('Address');

        $this->configure($payment);

        $gateway = $this->config['payment_url'] . '?order=' . $order->get('id') . '&';

        $orderDescription = $this->modx->lexicon('ms2_payment_bepaid_order_description', $order->toArray());

        $payload = [
            'checkout' => [
                'version' => $this->config[self::OPTION_API_VERSION],
                'test' => $this->config[self::OPTION_TEST_MODE] ? 'true' : 'false',
                'transaction_type' => 'payment',
                'settings' => [
                    'success_url' => $gateway . http_build_query(['action' => 'success']),
                    'decline_url' => $gateway . http_build_query(['action' => 'decline']),
                    'fail_url' => $gateway . http_build_query(['action' => 'fail']),
                    'cancel_url' => $gateway . http_build_query(['action' => 'cancel']),
                    'notification_url' => $gateway . http_build_query(['action' => 'notify']),
                    'language' => $this->config[self::OPTION_LANGUAGE],
                    'customer_fields' => $this->config['customer_fields']
                ],
                'order' => [
                    'currency' => $this->config[self::OPTION_CURRENCY],
                    'amount' => $this->amount($order->get('cost'), $this->config[self::OPTION_CURRENCY]),
                    'description' => $orderDescription,
                    'tracking_id' => $order->get('id')
                ],
                'customer' => $this->customer($address)
            ]
        ];

        if (!empty($this->config[self::OPTION_PAYMENT_TYPES])) {
            $paymentTypes = explode(',', strtolower($this->config[self::OPTION_PAYMENT_TYPES]));
            $payload['checkout']['payment_method']['types'] = $paymentTypes;
        } else {
            $paymentTypes = [];
        }

        if (in_array('erip', $paymentTypes)) {
            $payload['checkout']['payment_method']['erip'] = [
                'order_id' => $order->get('id'),
                'account_number' => $order->get('num'),
                'service_no' => $this->config[self::OPTION_ERIP_SERVICE_ID],
                'service_info' => [$orderDescription]
            ];
        }

        $response = $this->request($this->config[self::OPTION_CHECKOUT_URL], $payload);
        $response = json_decode($response, true);

        if (isset($response['checkout']) && isset($response['checkout']['redirect_url'])) {
            return $response['checkout']['redirect_url'];
        }

        $this->log('Response not valid and contains errors: ' . print_r($response, true),  __FILE__, __LINE__);

        return false;
    }

    /**
     * Converts amount to amount in minimal units, example for USD: if 100.45$, should be 10045
     * @param $amount
     * @param $currency
     * @return int
     */
    protected function amount($amount, $currency)
    {
        $precision = [
            'BIF' => 1,
            'CLF' => 1,
            'CLP' => 1,
            'CVE' => 1,
            'DJF' => 1,
            'GNF' => 1,
            'IDR' => 1,
            'IQD' => 1,
            'IRR' => 1,
            'ISK' => 1,
            'JPY' => 1,
            'KMF' => 1,
            'KPW' => 1,
            'KRW' => 1,
            'LAK' => 1,
            'LBP' => 1,
            'MMK' => 1,
            'PYG' => 1,
            'RWF' => 1,
            'SLL' => 1,
            'STD' => 1,
            'UYI' => 1,
            'VND' => 1,
            'VUV' => 1,
            'XAF' => 1,
            'XOF' => 1,
            'XPF' => 1,
            'MOP' => 10,
            'BHD' => 1000,
            'JOD' => 1000,
            'KWD' => 1000,
            'LYD' => 1000,
            'OMR' => 1000,
            'TND' => 1000
        ];

        $amount = (float) $amount;

        $multiplier = array_key_exists($currency, $precision)
            ? $precision[$currency]
            : 100; // default

        return intval(bcmul(abs($amount), $multiplier));
    }

    /**
     * @param msOrderAddress $address
     * @return array $customer Array with prepared info about customer, valid for bePaid services
     */
    protected function customer(msOrderAddress $address)
    {
        $customer = ['email' => $address->get('email')];

        $name = explode(' ', $address->get('receiver'), 2);

        if (isset($name[0])) {
            $customer['first_name'] = $name[0];
        }

        if (isset($name[1])) {
            $customer['last_name'] = $name[1];
        }

        if ($address->get('city')) {
            $customer['city'] = $address->get('city');
        }

        if ($address->get('region')) {
            $customer['state'] = $address->get('region');
        }

        if ($address->get('phone')) {
            $customer['phone'] = $address->get('phone');
        }

        if (mb_strlen($address->get('country')) == 2) { // country should be in ISO 3166-1 Alpha-2 format
            $customer['country'] = strtoupper($address->get('country'));
        }

        if (!$customer['country']) {
            $customer['country'] = strtoupper($this->config[self::OPTION_COUNTRY]);
        }

        if ($address->get('index')) {
            // If country == US, zip format must be NNNNN or NNNNN-NNNN.
            if ($customer['country'] == 'US' && preg_match('/([\d]{5}|[\d]{5}-[\d]{4})/g', $address->get('index'))) {
                $customer['zip'] = $address->get('index');
            }
            if ($customer['country'] != 'US') {
                $customer['zip'] = $address->get('index');
            }
        }

        $line = [];
        if ($address->get('street')) {
            $line[] = $address->get('street');
        }

        if ($address->get('building')) {
            $line[] = $address->get('building');
        }

        if ($address->get('room')) {
            $line[] = $address->get('room');
        }

        if ($address->get('metro')) {
            $line[] = $address->get('metro');
        }

        if (count($line)) {
            $customer['address'] = join(', ', $line);
        }

        return $customer;
    }

    /**
     * Do request to checkout gateway
     * @param $url
     * @param $payload
     * @param array $headers
     * @return mixed Response in JSON format
     */
    protected function request($url, $payload = null, $headers = [])
    {
        $headers = array_merge([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache'
        ], $headers);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, $payload ? true : false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function ($key, $value) {
            return join(': ', [$key, $value]);
        }, array_keys($headers), $headers));

        curl_setopt($ch, CURLOPT_USERPWD, join(':', [
            $this->config[self::OPTION_STORE_ID],
            $this->config[self::OPTION_SECRET_KEY]
        ]));

        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);

        curl_close($ch);

        // Special method for debugging requests
        // $this->log(print_r($info, true));

        if ($response === false) {
            $this->log('CURL error, can not process request via path "' . $url . '". Error info: ' . $error, __FILE__, __LINE__);
        }

        return $response;
    }

    /**
     * @param msOrder $order
     * @param $status
     */
    protected function changeOrderStatus(msOrder $order, $status)
    {
        if (!$status) {
            return;
        }

        $currentContext = $this->modx->context->get('key');
        $this->modx->switchContext('mgr');
        $this->ms2->changeOrderStatus($order->get('id'), $status);
        $this->modx->switchContext($currentContext);
    }

    /**
     * Process notify webhook from payment system
     * @param $order
     * @throws ReflectionException
     */
    public function notify(msOrder $order)
    {
        /** @var msPayment $payment */
        $payment = $order->getOne('Payment');

        $this->configure($payment);

        if ($_SERVER['PHP_AUTH_USER'] != $this->config[self::OPTION_STORE_ID]
            || $_SERVER['PHP_AUTH_PW'] != $this->config[self::OPTION_SECRET_KEY]
        ) {
            $msg = 'Notify response can not be authorized.';
            $this->log($msg);
            self::fail($msg);
        }

        $response = json_decode(file_get_contents('php://input'), true);

        if (isset($response['transaction']) && isset($response['transaction']['tracking_id'])
            && isset($response['transaction']['type']) && $response['transaction']['type'] == 'payment'
        ) {
            /** @var msOrder $order */
            if (!$order = $this->modx->getObject('msOrder', ['id' => $response['transaction']['tracking_id']])) {
                $msg = 'Requested order not found.';
                $this->log($msg);
                self::fail($msg);
            }

            // save info about transaction into order
            $props = $order->get('properties');
            $payment = $response['transaction']['payments'];
            $payment['uid'] = $response['transaction']['uid'];
            $payment['type'] = $response['transaction']['type'];
            $props['payments'][] = $payment;
            $order->set('properties', $props);
            $order->save();

            // check status of transaction
            if (isset($response['transaction']['status']) && $response['transaction']['status'] == 'successful') {
                $this->changeOrderStatus($order, $this->config[self::OPTION_SUCCESS_STATUS]);

                header("HTTP/1.0 200 OK"); // stop notify
                exit;
            }
            $msg = 'Transaction not processed yet.';
            $this->log($msg);
            self::fail($msg);
        }

        $msg = 'Notify response not valid.';
        $this->log($msg);
        self::fail($msg, $response);
    }

    /**
     * @param msOrder $order
     * @param $token
     * @param $uid
     * @param $status
     * @throws ReflectionException
     */
    public function process(msOrder $order, $token, $uid, $status)
    {
        /** @var msPayment $payment */
        $payment = $order->getOne('Payment');

        $this->configure($payment);

        $url = join('/', [$this->config[self::OPTION_CHECKOUT_URL], $token]);

        $response = json_decode($this->request($url), true);

        if ($response['checkout']['shop_id'] != $this->config[self::OPTION_STORE_ID]) {
            $this->log("Returned transaction not for this store, invalid store id ({$response['checkout']['shop_id']}). ", __FILE__, __LINE__);

            return;
        }

        if ($response['checkout']['gateway_response']['payment']['uid'] != $uid) {
            $this->log("Returned transaction uid ({$response['checkout']['gateway_response']['payment']['uid']}) not valid.", __FILE__, __LINE__);

            return;
        }

        /** @var msOrder $order*/
        if (!$order = $this->modx->getObject('msOrder', ['id' => $response['checkout']['order']['tracking_id']])) {
            $this->log("Cannot find order with id ({$response['checkout']['order']['payment']['tracking_id']}) for transaction accept.", __FILE__, __LINE__);

            return;
        }

        // save info about transaction into order
        $props = $order->get('properties');
        $payment = $response['checkout']['gateway_response']['payment'];
        $props['payments'][] = $payment;
        $order->set('properties', $props);
        $order->save();

        if ($status != 'successful'
            && !in_array($status, ['pending', 'auto_created', 'expired', 'permanent']) // ERIP
        ) {
            // need new page
            $this->log($response['checkout']['message'] . " for order " . $order->get('id'), __FILE__, __LINE__);

            $this->changeOrderStatus($order, $this->config[self::OPTION_FAILURE_STATUS]);

            return;
        }

        if (!$response['checkout']['finished']) {
            $this->log('Transaction not finished yet.', __FILE__, __LINE__);

            return;
        }

        $this->changeOrderStatus($order, $this->config[self::OPTION_SUCCESS_STATUS]);
    }

    /**
     * @param $msg
     */
    public function log($msg)
    {
        $this->modx->log(modX::LOG_LEVEL_ERROR, '[ms2::payment::bePaid] ' . $msg);
    }

    /**
     * @param $text
     * @param array $request
     */
    public static function fail($text, $request = [])
    {
        $text .= $request ? ', request: ' . print_r($request, true) : '';

        header("HTTP/1.0 400 Bad Request");
        die('ERROR: ' . $text);
    }
}
