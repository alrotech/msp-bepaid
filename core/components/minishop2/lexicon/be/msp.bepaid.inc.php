<?php

$_lang['area_ms2_payment_bepaid'] = 'bePaid';

$_lang['setting_ms2_payment_bepaid_store_id'] = 'ID of shop in bePaid System';
$_lang['setting_ms2_payment_bepaid_store_id_desc'] = 'It\'s contains an unique ID of shop. This ID was created after your registration in bePaid System and was sent by email.';

$_lang['setting_ms2_payment_bepaid_secret_key'] = 'Secret Key';
$_lang['setting_ms2_payment_bepaid_secret_key_desc'] = 'The sequence of random characters, given in panel bePaid. Participates in the formation of an signature and is used to verify the payment.';

$_lang['setting_ms2_payment_bepaid_login'] = 'Login in bePaid System';
$_lang['setting_ms2_payment_bepaid_login_desc'] = 'Login, with that you enter to control panel of bePaid. Needed for payment\'s check.';

$_lang['setting_ms2_payment_bepaid_password'] = 'Password in bePaid System';
$_lang['setting_ms2_payment_bepaid_password_desc'] = 'Password, with that you enter to control panel of bePaid. Needed for payment\'s check.';

$_lang['setting_ms2_payment_bepaid_checkout_url'] = 'Address for checkout queries';
$_lang['setting_ms2_payment_bepaid_checkout_url_desc'] = 'Address to be sent to the user to execute the payment order.';

$_lang['setting_ms2_payment_bepaid_gate_url'] = 'Address for payment\'s check';
$_lang['setting_ms2_payment_bepaid_gate_url_desc'] = 'Address to be sent to a request to check the payment. ';

$_lang['setting_ms2_payment_bepaid_version'] = 'Version of the payment form';
$_lang['setting_ms2_payment_bepaid_version_desc'] = 'Current version = 2.';

$_lang['setting_ms2_payment_bepaid_developer_mode'] = 'Test mode of payments';
$_lang['setting_ms2_payment_bepaid_developer_mode_desc'] = 'If the value "Yes", all requests payments will be send to a bePaid testing environment of payment processing. If you enabled this mode settings checkout_url and gate_url will be ignored.';

$_lang['setting_ms2_payment_bepaid_currency'] = 'The proposed currency of payment';
$_lang['setting_ms2_payment_bepaid_currency_desc'] = 'User can change it while paying. Literal-digit currency code according to ISO4271. Available variants: <strong>BYR</strong>, <strong>USD</strong>, <strong>EUR</strong>, <strong>RUB</strong>. In developer mode available only BYR.';

$_lang['setting_ms2_payment_bepaid_language'] = 'Мова bePaid';
$_lang['setting_ms2_payment_bepaid_language_desc'] = 'Specify the language code, which show\'s bePaid when paying. Available variants: <strong>russian</strong>, <strong>english</strong>.';

$_lang['setting_ms2_payment_bepaid_success_id'] = 'bePaid successful page id';
$_lang['setting_ms2_payment_bepaid_success_id_desc'] = 'The customer will be sent to this page after the completion of the payment. It is recommended to specify the id of the page with the shopping cart to order output.';

$_lang['setting_ms2_payment_bepaid_failure_id'] = 'bePaid failure page id';
$_lang['setting_ms2_payment_bepaid_failure_id_desc'] = 'The customer will be sent to this page if something went wrong. It is recommended to specify the id of the page with the shopping cart to order output.';


$_lang['ms2_payment_bepaid_order_description'] = 'Payment for order #[[+num]]';

$_lang['ms2_payment_bepaid_lang_english'] = 'Англійская';
$_lang['ms2_payment_bepaid_lang_spanish'] = 'Іспанская';
$_lang['ms2_payment_bepaid_lang_turkish'] = 'Турэцкая';
$_lang['ms2_payment_bepaid_lang_german'] = 'Нямецкая';
$_lang['ms2_payment_bepaid_lang_italian'] = 'Італьянская';
$_lang['ms2_payment_bepaid_lang_russian'] = 'Руская';
$_lang['ms2_payment_bepaid_lang_chinese'] = 'Кітайская';
$_lang['ms2_payment_bepaid_lang_french'] = 'Французкая';
$_lang['ms2_payment_bepaid_lang_danish'] = 'Дацкая';
$_lang['ms2_payment_bepaid_lang_swedish'] = 'Шведская';
$_lang['ms2_payment_bepaid_lang_norwegian'] = 'Нарвежская';
$_lang['ms2_payment_bepaid_lang_finnish'] = 'Фінская';
