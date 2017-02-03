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

/**
 * System settings resolver
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

if (!$object->xpdo && !$object->xpdo instanceof modX) {
    return true;
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        if (isset($options['bepaid_store_id'])
            && !$object->xpdo->getObject('modSystemSetting', ['key' => 'ms2_payment_bepaid_store_id'])) {
            /** @var modSystemSetting $storeId */
            $storeId = $object->xpdo->newObject('modSystemSetting');

            $storeId->fromArray([
                'namespace' => 'minishop2',
                'area' => 'ms2_payment_bepaid',
                'xtype' => 'textfield',
                'key' => 'ms2_payment_bepaid_store_id',
                'value' => $options['bepaid_store_id']
            ], '', true, true);
            $storeId->save();
        }
        if (isset($options['bepaid_secret_key'])
            && !$object->xpdo->getObject('modSystemSetting', ['key' => 'ms2_payment_bepaid_secret_key'])) {
            /** @var modSystemSetting $secretKey */
            $secretKey = $object->xpdo->newObject('modSystemSetting');

            $secretKey->fromArray([
                'namespace' => 'minishop2',
                'area' => 'ms2_payment_bepaid',
                'xtype' => 'textfield',
                'key' => 'ms2_payment_bepaid_secret_key',
                'value' => $options['bepaid_secret_key'],
            ], '', true, true);
            $secretKey->save();
        }
        break;

    case xPDOTransport::ACTION_UPGRADE:
        if (!$object->xpdo->getObject('modSystemSetting', ['key' => 'ms2_payment_bepaid_api_version'])) {
            /** @var modSystemSetting $apiVersion */
            $apiVersion = $object->xpdo->newObject('modSystemSetting');
            $apiVersion->fromArray([
                'namespace' => 'minishop2',
                'area' => 'ms2_payment_bepaid',
                'xtype' => 'textfield',
                'key' => 'ms2_payment_bepaid_api_version',
                'value' => 2
            ], '', true, true);
            $apiVersion->save();
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $modelPath = $object->xpdo->getOption('minishop2.core_path', null, $object->xpdo->getOption('core_path') . 'components/minishop2/') . 'model/';
        $object->xpdo->addPackage('minishop2', $modelPath);

        $object->xpdo->removeCollection('msPayment', ['class' => 'bePaid']);
        $object->xpdo->removeCollection('modSystemSetting', ['key:LIKE' => 'ms2\_payment\_bepaid\_%']);
        break;
}

return true;
