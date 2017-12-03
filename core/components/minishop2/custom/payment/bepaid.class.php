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
    require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}

class BePaid extends msPaymentHandler implements msPaymentInterface
{
    public $config;

    /**
     * @param xPDOObject $object
     * @param array $config
     */
    public function __construct(xPDOObject $object, $config = [])
    {
        parent::__construct($object, $config);

        $this->config = array_merge([
            'store_id' => $this->modx->getOption('ms2_payment_bepaid_store_id', null),
            'secret_key' => $this->modx->getOption('ms2_payment_bepaid_secret_key', null),
            'api_version' => $this->modx->getOption('ms2_payment_bepaid_api_version', 2),
            'checkout_url' => $this->modx->getOption('ms2_payment_bepaid_checkout_url', null, 'https://checkout.bepaid.by/ctp/api/checkouts'),
            'language' => $this->modx->getOption('ms2_payment_bepaid_language', null, $this->modx->getOption('cultureKey')),
            'currency' => $this->modx->getOption('ms2_payment_bepaid_currency', null, 'BYN'),
            'payment_url' => join('/', [
                rtrim($this->modx->getOption('site_url'), '/'),
                ltrim($this->modx->getOption('minishop2.assets_url', $config, $this->modx->getOption('assets_url') . 'components/minishop2'), '/'),
                'payment/bepaid.php'
            ]),
            'payment_types' => $this->modx->getOption('ms2_payment_bepaid_payment_types', null, ''),
            'erip_service' => $this->modx->getOption('ms2_payment_bepaid_erip_service_id', null, '99999999') // test value
        ], $config);

        $read_only = $this->modx->getOption('ms2_payment_bepaid_readonly_fields', null, '');
        $read_only = $read_only ? explode(',', $read_only) : null;
        if ($read_only) {
            $this->config['customer_fields']['read_only'] = $read_only;
        }

        $hidden = $this->modx->getOption('ms2_payment_bepaid_hidden_fields', null, '');
        $hidden = $hidden ? explode(',', $hidden) : null;
        if ($hidden) {
            $this->config['customer_fields']['hidden'] = $hidden;
        }

        if (!in_array($this->config['language'],
            ['en', 'es', 'tr', 'de', 'it', 'ru', 'zh', 'fr', 'da', 'sv', 'no', 'fi']
        )) {
            $this->config['language'] = 'en'; // english by default in other unimaginable cases
        }
    }

    /**
     * @param msOrder $order
     * @return array|string
     */
    public function send(msOrder $order)
    {
        if (!$link = $this->getPaymentToken($order)) {
            $this->log('Token and redirect url can not be requested.', __FILE__, __LINE__);
        }

        return $this->success('', ['redirect' => $link]);
    }

    /**
     * @param msOrder $order
     * @return bool|string
     */
    protected function getPaymentToken(msOrder $order)
    {
        /** @var msOrderAddress $address */
        $address = $order->getOne('Address');

        $gateway = $this->config['payment_url'] . '?order=' . $order->get('id') . '&';

        $orderDescription = $this->modx->lexicon('ms2_payment_bepaid_order_description', $order->toArray());

        $payload = [
            'checkout' => [
                'version' => $this->config['api_version'],
                'transaction_type' => 'payment',
                'settings' => [
                    'success_url' => $gateway . http_build_query(['action' => 'success']),
                    'decline_url' => $gateway . http_build_query(['action' => 'decline']),
                    'fail_url' => $gateway . http_build_query(['action' => 'fail']),
                    'cancel_url' => $gateway . http_build_query(['action' => 'cancel']),
                    'notification_url' => $gateway . http_build_query(['action' => 'notify']),
                    'language' => $this->config['language'],
                    'customer_fields' => $this->config['customer_fields']
                ],
                'order' => [
                    'currency' => $this->config['currency'],
                    'amount' => $this->amount($order->get('cost'), $this->modx->getOption('ms2_payment_bepaid_currency')),
                    'description' => $orderDescription,
                    'tracking_id' => $order->get('id')
                ],
                'customer' => $this->customer($address)
            ]
        ];

        if (!empty($this->config['payment_types'])) {
            $paymentTypes = explode(',', $this->config['payment_types']);
            $payload['checkout']['payment_method']['types'] = $paymentTypes;
        } else {
            $paymentTypes = [];
        }

        if (in_array('erip', $paymentTypes)) {
            $payload['checkout']['payment_method']['erip'] = [
                'order_id' => $order->get('id'),
                'account_number' => $order->get('num'),
                'service_no' => $this->config['erip_service'],
                'service_info' => [$orderDescription]
            ];
        }

        $response = $this->request($this->config['checkout_url'], $payload);
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

        $multiplyer = array_key_exists($currency, $precision)
            ? $precision[$currency]
            : 100; // default

        return intval($amount * $multiplyer);
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
            $customer['country'] = strtoupper($this->modx->getOption('ms2_payment_bepaid_country'));
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
            $this->config['store_id'],
            $this->config['secret_key']
        ]));

        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);

        curl_close($ch);

        // Special method for debugging requests
        // $this->log(print_r($info, true), __FILE__, __LINE__);

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
     */
    public function notify()
    {
        if ($_SERVER['PHP_AUTH_USER'] != $this->modx->getOption('ms2_payment_bepaid_store_id', null)
            || $_SERVER['PHP_AUTH_PW'] != $this->modx->getOption('ms2_payment_bepaid_secret_key', null)
        ) {
            $this->fail('Notify response can not be authorized.', __FILE__, __LINE__);
        }

        $response = json_decode(file_get_contents('php://input'), true);

        if (isset($response['transaction']) && isset($response['transaction']['tracking_id'])
            && isset($response['transaction']['type']) && $response['transaction']['type'] == 'payment'
        ) {
            /** @var msOrder $order */
            if (!$order = $this->modx->getObject('msOrder', ['id' => $response['transaction']['tracking_id']])) {
                $this->fail('Requested order not found.', __FILE__, __LINE__);
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
                $this->changeOrderStatus($order, $this->modx->getOption('ms2_payment_bepaid_success_status'));

                header("HTTP/1.0 200 OK"); // stop notify
                exit;
            }

            $this->fail('Transaction not processed yet.', __FILE__, __LINE__);
        }

        $this->fail('Notify response not valid.', __FILE__, __LINE__, $response);
    }

    /**
     * @param $token
     * @param $uid
     * @param $status
     */
    public function process($token, $uid, $status)
    {
        $url = join('/', [$this->config['checkout_url'], $token]);

        $response = json_decode($this->request($url), true);

        if ($response['checkout']['shop_id'] != $this->modx->getOption('ms2_payment_bepaid_store_id')) {
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

            $this->changeOrderStatus($order, $this->modx->getOption('ms2_payment_bepaid_failure_status'));

            return;
        }

        if (!$response['checkout']['finished']) {
            $this->log('Transaction not finished yet.', __FILE__, __LINE__);

            return;
        }

        $this->changeOrderStatus($order, $this->modx->getOption('ms2_payment_bepaid_success_status'));
    }

    /**
     * @param $msg
     * @param $file
     * @param $line
     */
    public function log($msg, $file, $line)
    {
        $msg = '[ms2::payment::bePaid] ' . $msg;

        $this->modx->log(modX::LOG_LEVEL_ERROR, $msg, '', '', $file, $line);
    }

    /**
     * @param $text
     * @param array $request
     */
    public function fail($text, $file, $line, $request = [])
    {
        $text .= $request ? ', request: ' . print_r($request, 1) : '';
        $this->log($text, $file, $line);

        header("HTTP/1.0 400 Bad Request");
        die('ERROR: ' . $text);
    }
}
