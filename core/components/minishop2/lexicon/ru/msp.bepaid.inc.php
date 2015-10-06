<?php

$_lang['area_ms2_payment_bepaid'] = 'bePaid';

$_lang['setting_ms2_payment_bepaid_store_id'] = 'Идентификатор магазина в системе bePaid';
$_lang['setting_ms2_payment_bepaid_store_id_desc'] = 'Данный идентификатор создается при регистрации в системе bePaid и высылается в письме.';

$_lang['setting_ms2_payment_bepaid_secret_key'] = 'Секретный ключ';
$_lang['setting_ms2_payment_bepaid_secret_key_desc'] = 'Последовательность случайных символов, участвует в формировании электронной подписи заказа, выдается при регистрации магазина в системе bePaid.';

$_lang['setting_ms2_payment_bepaid_language'] = 'Язык bePaid';
$_lang['setting_ms2_payment_bepaid_language_desc'] = 'Выберите язык, на котором показывать сайт bePaid при оплате. По умолчанию будет использоваться язык, установленный для сайта в системной настройке cultureKey.';

$_lang['setting_ms2_payment_bepaid_success_status'] = 'Статус заказа в случае успешной оплаты';
$_lang['setting_ms2_payment_bepaid_success_status_desc'] = 'Если заказ обработан без ошибок и со стороны банка транзакция авторизована, статус заказа будет изменен на указанный';

$_lang['setting_ms2_payment_bepaid_success_status'] = 'Статус заказа в случае ошибок оплаты';
$_lang['setting_ms2_payment_bepaid_success_status_desc'] = 'Если заказ не обработан или были ошибки в процессе оплаты, статус заказа будет изменен на указанный';

$_lang['setting_ms2_payment_bepaid_success_page'] = 'Страница успешной оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_success_page_desc'] = 'Пользователь будет отправлен на эту страницу после успешного завершения оплаты. Рекомендуется указать страницу с корзиной для вывода деталей заказа.';

$_lang['setting_ms2_payment_bepaid_failure_page'] = 'Страница отмены оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_failure_page_desc'] = 'Пользователь будет отправлен на эту страницу при неудачной оплате. Рекомендуется указать страницу с корзиной для вывода деталей заказа';

$_lang['setting_ms2_payment_bepaid_currency'] = 'Валюта платежа';
$_lang['setting_ms2_payment_bepaid_currency_desc'] = 'Буквенный трехзначный код валюты согласно <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">ISO 4271</a>.';





$_lang['setting_ms2_payment_bepaid_checkout_url'] = 'Адрес для выполнения запросов';
$_lang['setting_ms2_payment_bepaid_checkout_url_desc'] = 'Адрес, куда будет отправляться пользователь для выполнения оплаты заказа.';


$_lang['setting_ms2_payment_bepaid_developer_mode'] = 'Режим совершения тестовых платежей';
$_lang['setting_ms2_payment_bepaid_developer_mode_desc'] = 'При значении "Да", все запросы оплаты будут отправляться на тестовую среду обработки платежей bePaid. При включении данного режима настройки checkout_url и gate_url игнорируются.';





$_lang['ms2_payment_bepaid_order_description'] = 'Оплата заказа #[[+num]]';

$_lang['ms2_payment_bepaid_lang_english'] = 'Английский';
$_lang['ms2_payment_bepaid_lang_spanish'] = 'Испанский';
$_lang['ms2_payment_bepaid_lang_turkish'] = 'Турецкий';
$_lang['ms2_payment_bepaid_lang_german'] = 'Немецкий';
$_lang['ms2_payment_bepaid_lang_italian'] = 'Итальянский';
$_lang['ms2_payment_bepaid_lang_russian'] = 'Русский';
$_lang['ms2_payment_bepaid_lang_chinese'] = 'Китайский';
$_lang['ms2_payment_bepaid_lang_french'] = 'Французский';
$_lang['ms2_payment_bepaid_lang_danish'] = 'Датский';
$_lang['ms2_payment_bepaid_lang_swedish'] = 'Шведский';
$_lang['ms2_payment_bepaid_lang_norwegian'] = 'Норвежский';
$_lang['ms2_payment_bepaid_lang_finnish'] = 'Финский';
