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
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

$exists = false;

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $exists = $modx->getCount('modSystemSetting', array('key:LIKE' => '%_bepaid_%'));
        break;
}

if ($exists) {
    return;
}

$lexicon = array(
    'ru' => array(
        'title' => 'Настройка платежного модуля bePaid',
        'description' => 'По умолчанию заданы номер и секретный ключ тестового магазина. <a href="https://github.com/beGateway/begateway-api-php#test-data" target="_blank">Подробности тут.</a>',
        'info' => 'Вы можете пропустить этот шаг и изменить эти поля позже в системных настройках.',
        'store_id' => 'Идентификатор магазина',
        'secret_key' => 'Секретный ключ'
    ),
    'en' => array(
        'title' => '',
        'description' => 'By default set id and secret key of test store. <a href="https://github.com/beGateway/begateway-api-php#test-data" target="_blank">Detail here.</a>',
        'info' => 'You can skip this step and change this fields later in system settings.',
        'store_id' => 'Store ID',
        'secret_key' => 'Secret key'
    ),
    'be' => array(
        'title' => 'Наладка плацёжнага модуля bePaid',
        'description' => 'Па змоўчанню зададзены нумар і сакрэтны ключ тэставага магазіну. <a href="https://github.com/beGateway/begateway-api-php#test-data" target="_blank">Падрабязнасці тут.</a>',
        'info' => 'Вы можаце прапусціць гэты крок і змяніць гэтыя палі пазней у сістэмных наладках.',
        'store_id' => 'Ідэнтыфікатар магазіна',
        'secret_key' => 'Cакрэтны ключ'
    )
);

$locale = $modx->getOption('manager_language');
$language = array_key_exists($locale, $lexicon) ? $locale : 'en';
$translate = $lexicon[$language];

$output = <<<HTML
    <style>
        #setup_form_wrapper {font: normal 12px Arial;line-height:18px;}
        #setup_form_wrapper ul {margin-left: 5px; font-size: 10px; list-style: disc inside;}
        #setup_form_wrapper a {color: #08C;}
        #setup_form_wrapper small {font-size: 10px; color:#555; font-style:italic;}
        #setup_form_wrapper label {color: black; font-weight: bold;}
    </style>

    <div id="setup-form-wrapper">
        <h4>{$translate['title']}</h4>
        <span>{$translate['description']}</span>
        <label for="bepaid_store_id">{$translate['store_id']}</label>
        <input type="text" name="bepaid_store_id" id="bepaid_store_id" width="300" value="361" />
        <label for="bepaid_secret_key">{$translate['secret_key']}</label>
        <input type="text" name="bepaid_secret_key" id="bepaid_secret_key" width="300" value="b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d" />
        <small>{$translate['info']}</small>
    </div>
HTML;

return $output;
