<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2018 Ivan Klimchuk <ivan@klimchuk.com>
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

include_once 'base.class.php';

/**
 * Class mspBePaidPaymentPropertiesDeleteProcessor
 */
class mspBePaidPaymentPropertiesDeleteProcessor extends mspBePaidPaymentPropertiesBaseProcessor
{
    public function process()
    {
        $properties = $this->getPaymentProperties();

        $key = $this->getProperty(self::PROPERTY_KEY);

        if (!array_key_exists($key, $properties) && $key !== 'all') {
            $this->failure('ms2_payment_bepaid_props_key_nf');
        }

        if ($key === 'all') {
            $properties = [];
        } else {
            unset($properties[$key]);
        }

        return $this->savePaymentProperties($properties)
            ? $this->success()
            : $this->failure($this->modx->lexicon('ms2_payment_bepaid_save_props_err'));
    }
}

return mspBePaidPaymentPropertiesDeleteProcessor::class;
