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

        $this->config = array_merge([
            'store_id' => $this->modx->getOption('ms2_payment_bepaid_store_id'),
            'secret_key' => $this->modx->getOption('ms2_payment_bepaid_secret_key'),
            'checkout_url' => $this->modx->getOption('ms2_payment_bepaid_checkout_url', null, 'https://checkout.bepaid.by/ctp/api/checkouts'),
            'test_url' => $this->modx->getOption('ms2_payment_bepaid_test_url', null, 'https://checkout.begateway.com/ctp/api/checkouts'),
            'language' => $this->modx->getOption('ms2_payment_bepaid_language', null, $this->modx->getOption('cultureKey')),
            'currency' => $this->modx->getOption('ms2_payment_bepaid_currency', null, 'BYR'),
            'customer_fields' => [
                'read_only' => explode(',', $this->modx->getOption('ms2_payment_bepaid_readonly_fields', null, '')),
                'hidden' => explode(',', $this->modx->getOption('ms2_payment_bepaid_hidden_fields', null, '')),
            ],
            'payment_url' => join('/', [
                $this->modx->getOption('site_url'),
                $this->modx->getOption('minishop2.assets_url', $config, $this->modx->getOption('assets_url') . 'components/minishop2'),
                'payment/bepaid.php'
            ])
        ], $config);

        if ($this->modx->getOption('ms2_payment_bepaid_test_mode', null, true)) {
            $this->config['checkout_url'] = $config['test_url'];
        }
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
        /** @var msOrderAddress $address */
        $address = $order->getOne('Address');

        $gateway = $this->config['payment_url'] . '?';

        $payload = [
            'checkout' => [
                'transaction_type' => 'payment',
                'settings' => [
                    'success_url' => $gateway . http_build_query(['action' => 'success']),
                    'decline_url' => $gateway . http_build_query(['action' => 'decline']),
                    'fail_url' => $gateway . http_build_query(['action' => 'fail']),
                    'cancel_url' => $gateway . http_build_query(['action' => 'cancel']),
                    'notification_url' => $gateway . http_build_query(['action' => 'notify']),
                    'language' => $this->config['language'],
                    'customer_fields' => $this->config['customer_fields'],
                    'tracking_id' => $order->get('id')
                ],
                'order' => [
                    'currency' => $this->config['currency'],
                    'amount' => $this->prepareAmount($order->get('cost')),
                    'description' => $this->modx->lexicon('ms2_payment_bepaid_order_description', $order)
                ],
                'customer' => $this->getCustomerInfo($address)
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

        if (isset($response['checkout']) && isset($response['checkout']['redirect_url'])) {
            return $response['checkout']['redirect_url'];
        }

        $this->modx->log(modX::LOG_LEVEL_ERROR, '[ms2::payment::bePaid] Response not valid and contains errors: ' . $response);

        return false;
    }

    /**
     * Converts amount to amount in minimal units, example for USD: if 100.45$, should be 10045
     * @param $amount
     * @return int
     */
    protected function prepareAmount($amount)
    {
        if (!is_integer($amount)) {
            $amount = intval(round($amount, 2) * 100);
        }

        return intval($amount);
    }

    /**
     * @param msOrderAddress $address
     * @return array $customer Array with prepared info about customer, valid for bePaid services
     */
    protected function getCustomerInfo(msOrderAddress $address)
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
            $customer['country'] = $address->get('country');
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

        $customer['address'] = join(', ', $line);

        return $customer;
    }

    /**
     * Do request to checkout gateway
     * @param $url
     * @param $payload
     * @param array $headers
     * @param array $auth
     * @return mixed Response in JSON format
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
     * @deprecated
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
