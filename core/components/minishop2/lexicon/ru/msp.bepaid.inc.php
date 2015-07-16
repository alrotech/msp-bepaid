<?php

$_lang['area_ms2_payment_bepaid'] = 'bePaid';

$_lang['setting_ms2_payment_bepaid_store_id'] = 'Идентификатор магазина в системе bePaid';
$_lang['setting_ms2_payment_bepaid_store_id_desc'] = 'Cодержит уникальный идентификатор магазина. Данный идентификатор создается при регистрации в системе bePaid и высылается в письме.';

$_lang['setting_ms2_payment_bepaid_secret_key'] = 'Секретный ключ';
$_lang['setting_ms2_payment_bepaid_secret_key_desc'] = 'Последовательность случайных символов, задаваемая в панели bePaid. Участвует в формировании электронной подписи и используется для проверки платежей.';

$_lang['setting_ms2_payment_bepaid_login'] = 'Логин в системе bePaid';
$_lang['setting_ms2_payment_bepaid_login_desc'] = 'Логин, с которым вы входите в панель управления bePaid. Нужен для проверки платежа.';

$_lang['setting_ms2_payment_bepaid_password'] = 'Пароль в системе bePaid';
$_lang['setting_ms2_payment_bepaid_password_desc'] = 'Логин, с которым вы входите в панель управления bePaid. Нужен для проверки платежа.';

$_lang['setting_ms2_payment_bepaid_checkout_url'] = 'Адрес для выполнения запросов';
$_lang['setting_ms2_payment_bepaid_checkout_url_desc'] = 'Адрес, куда будет отправляться пользователь для выполнения оплаты заказа.';

$_lang['setting_ms2_payment_bepaid_gate_url'] = 'Адрес для выполнения проверки платежа';
$_lang['setting_ms2_payment_bepaid_gate_url_desc'] = 'Адрес, куда будет отправляться запрос на проверку платежа.';

$_lang['setting_ms2_payment_bepaid_version'] = 'Версия формы оплаты';
$_lang['setting_ms2_payment_bepaid_version_desc'] = 'Текущий номер версии = 2.';

$_lang['setting_ms2_payment_bepaid_developer_mode'] = 'Режим совершения тестовых платежей';
$_lang['setting_ms2_payment_bepaid_developer_mode_desc'] = 'При значении "Да", все запросы оплаты будут отправляться на тестовую среду обработки платежей bePaid. При включении данного режима настройки checkout_url и gate_url игнорируются.';

$_lang['setting_ms2_payment_bepaid_currency'] = 'Предлагаемая валюта платежа';
$_lang['setting_ms2_payment_bepaid_currency_desc'] = 'Пользователь может изменить ее в процессе оплаты. Буквенный трехзначный код валюты согласно ISO4271. Доступны варианты: BYR, USD, EUR, RUB. В режиме тестирования доступна только BYR.';

$_lang['setting_ms2_payment_bepaid_language'] = 'Язык bePaid';
$_lang['setting_ms2_payment_bepaid_language_desc'] = 'Укажите код языка, на котором показывать сайт bePaid при оплате. Доступны варианты: <strong>russian</strong>, <strong>english</strong>.';

$_lang['setting_ms2_payment_bepaid_success_id'] = 'Страница успешной оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_success_id_desc'] = 'Пользователь будет отправлен на эту страницу после завершения оплаты. Рекомендуется указать id страницы с корзиной, для вывода заказа.';

$_lang['setting_ms2_payment_bepaid_failure_id'] = 'Страница отказа от оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_failure_id_desc'] = 'Пользователь будет отправлен на эту страницу при неудачной оплате. Рекомендуется указать id страницы с корзиной, для вывода заказа';