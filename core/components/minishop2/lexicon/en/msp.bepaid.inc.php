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

$_lang['ms2_payment_bepaid_order_description'] = 'Payment for order #[[+num]]';

$_lang['ms2_payment_bepaid_lang_english'] = 'English';
$_lang['ms2_payment_bepaid_lang_spanish'] = 'Spanish';
$_lang['ms2_payment_bepaid_lang_turkish'] = 'Turkish';
$_lang['ms2_payment_bepaid_lang_german'] = 'German';
$_lang['ms2_payment_bepaid_lang_italian'] = 'Italian';
$_lang['ms2_payment_bepaid_lang_russian'] = 'Russian';
$_lang['ms2_payment_bepaid_lang_chinese'] = 'Chinese';
$_lang['ms2_payment_bepaid_lang_french'] = 'French';
$_lang['ms2_payment_bepaid_lang_danish'] = 'Danish';
$_lang['ms2_payment_bepaid_lang_swedish'] = 'Swedish';
$_lang['ms2_payment_bepaid_lang_norwegian'] = 'Norwegian';
$_lang['ms2_payment_bepaid_lang_finnish'] = 'Finnish';

//settings
$_lang['area_ms2_payment_bepaid'] = 'bePaid';

$_lang['setting_ms2_payment_bepaid_store_id'] = 'ID of shop in bePaid system';
$_lang['setting_ms2_payment_bepaid_store_id_desc'] = 'This ID are created during the registration of shop in bePaid system and sent via email.';

$_lang['setting_ms2_payment_bepaid_secret_key'] = 'Secret Key';
$_lang['setting_ms2_payment_bepaid_secret_key_desc'] = 'The sequence of random characters involved in the formation of the signature of order, was sent during the registration shop in the bePaid system.';

$_lang['setting_ms2_payment_bepaid_language'] = 'bePaid Language';
$_lang['setting_ms2_payment_bepaid_language_desc'] = 'Choose language, on which will be showed bePaid website during payment. By default will be used language set in system setting cultureKey.';

$_lang['setting_ms2_payment_bepaid_country'] = 'Country by default';
$_lang['setting_ms2_payment_bepaid_country_desc'] = 'Choose country, which will be used by default during payment. Choosing of the country can be redefined via cart functionality. Recommended to choose country where shop is placed.';

$_lang['setting_ms2_payment_bepaid_success_status'] = 'Order status if payment was successful';
$_lang['setting_ms2_payment_bepaid_success_status_desc'] = 'If order processed without errors and transaction are authorized, status of order will be changed to the specified.';

$_lang['setting_ms2_payment_bepaid_failure_status'] = 'Order status if payment was failed';
$_lang['setting_ms2_payment_bepaid_failure_status_desc'] = 'If order not processed or errors occurred during payment, status of order will be changed to the specified.';

$_lang['setting_ms2_payment_bepaid_success_page'] = 'Destination page after successful payment';
$_lang['setting_ms2_payment_bepaid_success_page_desc'] = 'User will be redirected to the specified page after successful payment. Recommended to specify page with cart for show details of order.';

$_lang['setting_ms2_payment_bepaid_failure_page'] = 'Destination page after failed/canceled payment';
$_lang['setting_ms2_payment_bepaid_failure_page_desc'] = 'User will be redirected to the specified page after failed or canceled payment. Recommended to specify page with cart for show details of order.';

$_lang['setting_ms2_payment_bepaid_currency'] = 'Currency of payment';
$_lang['setting_ms2_payment_bepaid_currency_desc'] = 'Literal three-digit code of currency according to <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">ISO 4271</a>.';

$_lang['setting_ms2_payment_bepaid_checkout_url'] = 'API entry point';
$_lang['setting_ms2_payment_bepaid_checkout_url_desc'] = 'URL to which will be sent payment queries.';

$_lang['setting_ms2_payment_bepaid_test_mode'] = 'Test mode';
$_lang['setting_ms2_payment_bepaid_test_mode_desc'] = 'If specified "Yes" all requests will be sent to sandbox. Real card in this mode are not working.';

$_lang['setting_ms2_payment_bepaid_readonly_fields'] = 'Read only orders properties';
$_lang['setting_ms2_payment_bepaid_readonly_fields_desc'] = 'Orders fields, listed here, on payment page will be showed as read only fields (not able to edit). List of available fields (separate by comma): <b>email</b>, <b>first_name</b>, <b>last_name</b>, <b>address</b>, <b>city</b>, <b>state</b>, <b>zip</b>, <b>phone</b>, <b>country</b>.';

$_lang['setting_ms2_payment_bepaid_hidden_fields'] = 'Hidden orders properties';
$_lang['setting_ms2_payment_bepaid_hidden_fields_desc'] = 'Orders fields, listed here, on payment page will be hidden, but still will be stored in payment details. List of available fields (separate by comma): <b>phone</b>, <b>address</b>.';

$_lang['setting_ms2_payment_bepaid_payment_types'] = 'Available payment methods';
$_lang['setting_ms2_payment_bepaid_payment_types_desc'] = 'An array of payment methods for displaying on the payment page. The following values are available: <b>credit_card</b>, <b>erip</b>, <b>halva</b>. For ERIP, you also need to specify the value of <b>erip_service_id</b>.';

$_lang['setting_ms2_payment_bepaid_erip_service_id'] = 'ERIP service code';
$_lang['setting_ms2_payment_bepaid_erip_service_id_desc'] = 'Unique code of a store or service registered for the seller in the "Raschet" system. For tests, use the value: <b>99999999</b>.';

$_lang['setting_ms2_payment_bepaid_api_version'] = 'Billing page version';
$_lang['setting_ms2_payment_bepaid_api_version_desc'] = 'Currently, the actual version of the protocol is <b>2.1</b>. If you installed the component earlier, this value should be updated manually.';

// countries
$_lang['ms2_payment_bepaid country au'] = 'Australia';
$_lang['ms2_payment_bepaid_country_at'] = 'Austria';
$_lang['ms2_payment_bepaid_country_az'] = 'Azerbaijan';
$_lang['ms2_payment_bepaid_country_ax'] = 'Aland Islands';
$_lang['ms2_payment_bepaid_country_al'] = 'Albania';
$_lang['ms2_payment_bepaid_country_dz'] = 'Algeria';
$_lang['ms2_payment_bepaid_country_as'] = 'American Samoa';
$_lang['ms2_payment_bepaid_country_ai'] = 'Anguilla';
$_lang['ms2_payment_bepaid_country_ao'] = 'Angola';
$_lang['ms2_payment_bepaid_country_ad'] = 'Andorra';
$_lang['ms2_payment_bepaid_country_aq'] = 'Antarctica';
$_lang['ms2_payment_bepaid_country_ag'] = 'Antigua and Barbuda';
$_lang['ms2_payment_bepaid_country_ar'] = 'Argentina';
$_lang['ms2_payment_bepaid_country_am'] = 'Armenia';
$_lang['ms2_payment_bepaid_country_aw'] = 'Aruba';
$_lang['ms2_payment_bepaid_country_af'] = 'Afghanistan';
$_lang['ms2_payment_bepaid_country_bs'] = 'Bahamas';
$_lang['ms2_payment_bepaid_country_bd'] = 'Bangladesh';
$_lang['ms2_payment_bepaid_country_bb'] = 'Barbados';
$_lang['ms2_payment_bepaid_country_bh'] = 'Bahrain';
$_lang['ms2_payment_bepaid_country_by'] = 'Belarus';
$_lang['ms2_payment_bepaid_country_bz'] = 'Belize';
$_lang['ms2_payment_bepaid_country_be'] = 'Belgium';
$_lang['ms2_payment_bepaid_country_bj'] = 'Benin';
$_lang['ms2_payment_bepaid_country_bm'] = 'Bermuda';
$_lang['ms2_payment_bepaid_country_bg'] = 'Bulgaria';
$_lang['ms2_payment_bepaid_country_bo'] = 'Bolivia';
$_lang['ms2_payment_bepaid_country_bq'] = 'Bonaire, Sint Eustatius and Saba';
$_lang['ms2_payment_bepaid_country_ba'] = 'Bosnia and Herzegovina';
$_lang['ms2_payment_bepaid_country_bw'] = 'Botswana';
$_lang['ms2_payment_bepaid_country_br'] = 'Brazil';
$_lang['ms2_payment_bepaid_country_io'] = 'British territory in the Indian Ocean';
$_lang['ms2_payment_bepaid_country_bn'] = 'Brunei Darussalam';
$_lang['ms2_payment_bepaid_country_bf'] = 'Burkina Faso';
$_lang['ms2_payment_bepaid_country_bi'] = 'Burundi';
$_lang['ms2_payment_bepaid_country_bt'] = 'Bhutan';
$_lang['ms2_payment_bepaid_country_vu'] = 'Vanuatu';
$_lang['ms2_payment_bepaid_country_gb'] = 'United Kingdom';
$_lang['ms2_payment_bepaid_country_hu'] = 'Hungary';
$_lang['ms2_payment_bepaid_country_ve'] = 'Venezuela';
$_lang['ms2_payment_bepaid_country_vg'] = 'Virgin Islands, British';
$_lang['ms2_payment_bepaid_country_vi'] = 'Virgin Islands, the United States';
$_lang['ms2_payment_bepaid_country_um'] = 'Minor Outlying Islands (USA)';
$_lang['ms2_payment_bepaid_country_vn'] = 'Vietnam';
$_lang['ms2_payment_bepaid_country_ga'] = 'Gabon';
$_lang['ms2_payment_bepaid_country_ht'] = 'Haiti';
$_lang['ms2_payment_bepaid_country_gy'] = 'Guyana';
$_lang['ms2_payment_bepaid_country_gm'] = 'Gambia';
$_lang['ms2_payment_bepaid_country_gh'] = 'Ghana';
$_lang['ms2_payment_bepaid_country_gp'] = 'Guadalupe';
$_lang['ms2_payment_bepaid_country_gt'] = 'Guatemala';
$_lang['ms2_payment_bepaid_country_gn'] = 'Guinea';
$_lang['ms2_payment_bepaid_country_gw'] = 'Guinea-Bissau';
$_lang['ms2_payment_bepaid_country_de'] = 'Germany';
$_lang['ms2_payment_bepaid_country_gg'] = 'Guernsey';
$_lang['ms2_payment_bepaid_country_gi'] = 'Gibraltar';
$_lang['ms2_payment_bepaid_country_hn'] = 'Honduras';
$_lang['ms2_payment_bepaid_country_hk'] = 'Hong Kong';
$_lang['ms2_payment_bepaid_country_gd'] = 'Granada';
$_lang['ms2_payment_bepaid_country_gl'] = 'Greenland';
$_lang['ms2_payment_bepaid_country_gr'] = 'Greece';
$_lang['ms2_payment_bepaid_country_ge'] = 'Georgia';
$_lang['ms2_payment_bepaid_country_gu'] = 'Guam';
$_lang['ms2_payment_bepaid_country_dk'] = 'Denmark';
$_lang['ms2_payment_bepaid_country_je'] = 'Jersey';
$_lang['ms2_payment_bepaid_country_dj'] = 'Djibouti';
$_lang['ms2_payment_bepaid_country_dm'] = 'Dominique';
$_lang['ms2_payment_bepaid_country_do'] = 'Dominican Republic';
$_lang['ms2_payment_bepaid_country_eg'] = 'Egypt';
$_lang['ms2_payment_bepaid_country_zm'] = 'Zambia';
$_lang['ms2_payment_bepaid_country_eh'] = 'Western Sahara';
$_lang['ms2_payment_bepaid_country_zw'] = 'Zimbabwe';
$_lang['ms2_payment_bepaid_country_il'] = 'Israel';
$_lang['ms2_payment_bepaid_country_in'] = 'India';
$_lang['ms2_payment_bepaid_country_id'] = 'Indonesia';
$_lang['ms2_payment_bepaid_country_jo'] = 'Jordan';
$_lang['ms2_payment_bepaid_country_iq'] = 'Iraq';
$_lang['ms2_payment_bepaid_country_ir'] = 'The Islamic Republic Iran';
$_lang['ms2_payment_bepaid_country_ie'] = 'Ireland';
$_lang['ms2_payment_bepaid_country_is'] = 'Iceland';
$_lang['ms2_payment_bepaid_country_es'] = 'Spain';
$_lang['ms2_payment_bepaid_country_it'] = 'Italy';
$_lang['ms2_payment_bepaid_country_ye'] = 'Yemen';
$_lang['ms2_payment_bepaid_country_cv'] = 'Cape Verde';
$_lang['ms2_payment_bepaid_country_kz'] = 'Kazakhstan';
$_lang['ms2_payment_bepaid_country_ky'] = 'Cayman Islands';
$_lang['ms2_payment_bepaid_country_kh'] = 'Cambodia';
$_lang['ms2_payment_bepaid_country_cm'] = 'Cameroon';
$_lang['ms2_payment_bepaid_country_ca'] = 'Canada';
$_lang['ms2_payment_bepaid_country_qa'] = 'Qatar';
$_lang['ms2_payment_bepaid_country_ke'] = 'Kenya';
$_lang['ms2_payment_bepaid_country_cy'] = 'Cyprus';
$_lang['ms2_payment_bepaid_country_ki'] = 'Kiribati';
$_lang['ms2_payment_bepaid_country_cn'] = 'China';
$_lang['ms2_payment_bepaid_country_cc'] = 'Cocos';
$_lang['ms2_payment_bepaid_country_co'] = 'DC';
$_lang['ms2_payment_bepaid_country_km'] = 'Comoros';
$_lang['ms2_payment_bepaid_country_cg'] = 'Congo';
$_lang['ms2_payment_bepaid_country_cd'] = 'Democratic Republic Congo';
$_lang['ms2_payment_bepaid_country_kp'] = 'North Korea';
$_lang['ms2_payment_bepaid_country_cr'] = 'Costa Rica';
$_lang['ms2_payment_bepaid_country_ci'] = 'Cote d\'Ivoire';
$_lang['ms2_payment_bepaid_country_cu'] = 'Cuba';
$_lang['ms2_payment_bepaid_country_kw'] = 'Kuwait';
$_lang['ms2_payment_bepaid_country_kg'] = 'Belarus';
$_lang['ms2_payment_bepaid_country_cw'] = 'Curacao';
$_lang['ms2_payment_bepaid_country_la'] = 'The Lao People\'s Democratic Republic';
$_lang['ms2_payment_bepaid_country_lv'] = 'Latvia';
$_lang['ms2_payment_bepaid_country_ls'] = 'Lesotho';
$_lang['ms2_payment_bepaid_country_lr'] = 'Liberia';
$_lang['ms2_payment_bepaid_country_lb'] = 'Lebanon';
$_lang['ms2_payment_bepaid_country_ly'] = 'Libya';
$_lang['ms2_payment_bepaid_country_lt'] = 'Lithuania';
$_lang['ms2_payment_bepaid_country_li'] = 'Liechtenstein';
$_lang['ms2_payment_bepaid_country_lu'] = 'Luxembourg';
$_lang['ms2_payment_bepaid_country_mu'] = 'Mauritius';
$_lang['ms2_payment_bepaid_country_mr'] = 'Mauritania';
$_lang['ms2_payment_bepaid_country_mg'] = 'Madagascar';
$_lang['ms2_payment_bepaid_country_yt'] = 'Mayotte';
$_lang['ms2_payment_bepaid_country_mo'] = 'Macau';
$_lang['ms2_payment_bepaid_country_mk'] = 'Republic of Macedonia';
$_lang['ms2_payment_bepaid_country_mw'] = 'Malawi';
$_lang['ms2_payment_bepaid_country_my'] = 'Malaysia';
$_lang['ms2_payment_bepaid_country_ml'] = 'Mali';
$_lang['ms2_payment_bepaid_country_mv'] = 'Maldives';
$_lang['ms2_payment_bepaid_country_mt'] = 'Malta';
$_lang['ms2_payment_bepaid_country_ma'] = 'Morocco';
$_lang['ms2_payment_bepaid_country_mq'] = 'Martinique';
$_lang['ms2_payment_bepaid_country_mh'] = 'Marshall';
$_lang['ms2_payment_bepaid_country_mx'] = 'Mexico';
$_lang['ms2_payment_bepaid_country_fm'] = 'Federated States Micronesia';
$_lang['ms2_payment_bepaid_country_mz'] = 'Mozambique';
$_lang['ms2_payment_bepaid_country_md'] = 'Moldova';
$_lang['ms2_payment_bepaid_country_mc'] = 'Monaco';
$_lang['ms2_payment_bepaid_country_mn'] = 'Mongolia';
$_lang['ms2_payment_bepaid_country_ms'] = 'Montserrat';
$_lang['ms2_payment_bepaid_country_mm'] = 'Myanmar';
$_lang['ms2_payment_bepaid_country_na'] = 'Namibia';
$_lang['ms2_payment_bepaid_country_nr'] = 'Nauru';
$_lang['ms2_payment_bepaid_country_np'] = 'Nepal';
$_lang['ms2_payment_bepaid_country_ne'] = 'Niger';
$_lang['ms2_payment_bepaid_country_ng'] = 'Nigeria';
$_lang['ms2_payment_bepaid_country_nl'] = 'the Netherlands';
$_lang['ms2_payment_bepaid_country_ni'] = 'Nicaragua';
$_lang['ms2_payment_bepaid_country_nu'] = 'Niue';
$_lang['ms2_payment_bepaid_country_nz'] = 'New Zealand';
$_lang['ms2_payment_bepaid_country_nc'] = 'New Caledonia';
$_lang['ms2_payment_bepaid_country_no'] = 'Norway';
$_lang['ms2_payment_bepaid_country_ae'] = 'United Arab Emirates';
$_lang['ms2_payment_bepaid_country_om'] = 'Oman';
$_lang['ms2_payment_bepaid_country_bv'] = 'Bouvet Island';
$_lang['ms2_payment_bepaid_country_im'] = 'Isle of Man';
$_lang['ms2_payment_bepaid_country_nf'] = 'Norfolk Island';
$_lang['ms2_payment_bepaid_country_sh'] = 'Saint Helena';
$_lang['ms2_payment_bepaid_country_hm'] = 'Heard Island and McDonald Islands';
$_lang['ms2_payment_bepaid_country_ck'] = 'Cook Islands';
$_lang['ms2_payment_bepaid_country_cx'] = 'Christmas Island';
$_lang['ms2_payment_bepaid_country_tc'] = 'Turks and Caicos Islands';
$_lang['ms2_payment_bepaid_country_pk'] = 'Pakistan';
$_lang['ms2_payment_bepaid_country_pw'] = 'Palau';
$_lang['ms2_payment_bepaid_country_ps'] = 'Palestinian Territories';
$_lang['ms2_payment_bepaid_country_pa'] = 'Panama';
$_lang['ms2_payment_bepaid_country_pg'] = 'Papua New Guinea';
$_lang['ms2_payment_bepaid_country_py'] = 'Paraguay';
$_lang['ms2_payment_bepaid_country_pe'] = 'Peru';
$_lang['ms2_payment_bepaid_country_pn'] = 'Pitcairn';
$_lang['ms2_payment_bepaid_country_pl'] = 'Poland';
$_lang['ms2_payment_bepaid_country_pt'] = 'Portugal';
$_lang['ms2_payment_bepaid_country_kr'] = 'South Korea';
$_lang['ms2_payment_bepaid_country_re'] = 'Reunion';
$_lang['ms2_payment_bepaid_country_ru'] = 'The Russian Federation';
$_lang['ms2_payment_bepaid_country_rw'] = 'Rwanda';
$_lang['ms2_payment_bepaid_country_ro'] = 'Romania';
$_lang['ms2_payment_bepaid_country_sv'] = 'Salvador';
$_lang['ms2_payment_bepaid_country_ws'] = 'Samoa';
$_lang['ms2_payment_bepaid_country_sm'] = 'San Marino';
$_lang['ms2_payment_bepaid_country_st'] = 'São Tomé and Principe';
$_lang['ms2_payment_bepaid_country_sa'] = 'Saudi Arabia';
$_lang['ms2_payment_bepaid_country_sz'] = 'Swaziland';
$_lang['ms2_payment_bepaid_country_va'] = 'The Holy See (Vatican City State)';
$_lang['ms2_payment_bepaid_country_mp'] = 'Northern Mariana Islands';
$_lang['ms2_payment_bepaid_country_sc'] = 'Seychelles';
$_lang['ms2_payment_bepaid_country_bl'] = 'Saint Barthelemy';
$_lang['ms2_payment_bepaid_country_mf'] = 'Saint-Martin (French part)';
$_lang['ms2_payment_bepaid_country_pm'] = 'Saint Pierre and Miquelon';
$_lang['ms2_payment_bepaid_country_sn'] = 'Senegal';
$_lang['ms2_payment_bepaid_country_vc'] = 'St. Vincent and the Grenadines';
$_lang['ms2_payment_bepaid_country_kn'] = 'Saint Kitts and Nevis';
$_lang['ms2_payment_bepaid_country_lc'] = 'Saint Lucia';
$_lang['ms2_payment_bepaid_country_rs'] = 'Serbia';
$_lang['ms2_payment_bepaid_country_sg'] = 'Singapore';
$_lang['ms2_payment_bepaid_country_sx'] = 'Sint Maarten (Dutch side)';
$_lang['ms2_payment_bepaid_country_sy'] = 'Syria';
$_lang['ms2_payment_bepaid_country_sk'] = 'Slovakia';
$_lang['ms2_payment_bepaid_country_si'] = 'Slovenia';
$_lang['ms2_payment_bepaid_country_us'] = 'United States';
$_lang['ms2_payment_bepaid_country_sb'] = 'Solomon Islands';
$_lang['ms2_payment_bepaid_country_so'] = 'Somalia';
$_lang['ms2_payment_bepaid_country_sd'] = 'Sudan';
$_lang['ms2_payment_bepaid_country_sr'] = 'Suriname';
$_lang['ms2_payment_bepaid_country_sl'] = 'Sierra Leone';
$_lang['ms2_payment_bepaid_country_tj'] = 'Tajikistan';
$_lang['ms2_payment_bepaid_country_th'] = 'Thailand';
$_lang['ms2_payment_bepaid_country_tw'] = 'Taiwan';
$_lang['ms2_payment_bepaid_country_tz'] = 'United Republic of Tanzania';
$_lang['ms2_payment_bepaid_country_tl'] = 'Timor-Leste';
$_lang['ms2_payment_bepaid_country_tg'] = 'Him';
$_lang['ms2_payment_bepaid_country_tk'] = 'Tokelau';
$_lang['ms2_payment_bepaid_country_to'] = 'Tonga';
$_lang['ms2_payment_bepaid_country_tt'] = 'Trinidad and Tobago';
$_lang['ms2_payment_bepaid_country_tv'] = 'Tuvalu';
$_lang['ms2_payment_bepaid_country_tn'] = 'Tunisia';
$_lang['ms2_payment_bepaid_country_tm'] = 'Turkmenistan';
$_lang['ms2_payment_bepaid_country_tr'] = 'Turkey';
$_lang['ms2_payment_bepaid_country_ug'] = 'Uganda';
$_lang['ms2_payment_bepaid_country_uz'] = 'Uzbekistan';
$_lang['ms2_payment_bepaid_country_ua'] = 'Ukraine';
$_lang['ms2_payment_bepaid_country_wf'] = 'Wallis and Futuna';
$_lang['ms2_payment_bepaid_country_uy'] = 'Uruguay';
$_lang['ms2_payment_bepaid_country_fo'] = 'Faroe Islands';
$_lang['ms2_payment_bepaid_country_fj'] = 'Fiji';
$_lang['ms2_payment_bepaid_country_ph'] = 'Philippines';
$_lang['ms2_payment_bepaid_country_fi'] = 'Finland';
$_lang['ms2_payment_bepaid_country_fk'] = 'Falkland Islands (Malvinas)';
$_lang['ms2_payment_bepaid_country_fr'] = 'France';
$_lang['ms2_payment_bepaid_country_gf'] = 'French Guiana';
$_lang['ms2_payment_bepaid_country_pf'] = 'French Polynesia';
$_lang['ms2_payment_bepaid_country_tf'] = 'French Southern Territories';
$_lang['ms2_payment_bepaid_country_hr'] = 'Croatia';
$_lang['ms2_payment_bepaid_country_cf'] = 'Central African Republic';
$_lang['ms2_payment_bepaid_country_td'] = 'Chad';
$_lang['ms2_payment_bepaid_country_me'] = 'Montenegro';
$_lang['ms2_payment_bepaid_country_cz'] = 'Czech Republic';
$_lang['ms2_payment_bepaid_country_cl'] = 'Chile';
$_lang['ms2_payment_bepaid_country_ch'] = 'Switzerland';
$_lang['ms2_payment_bepaid_country_se'] = 'Sweden';
$_lang['ms2_payment_bepaid_country_sj'] = 'Svalbard and Jan Mayen';
$_lang['ms2_payment_bepaid_country_lk'] = 'Sri Lanka';
$_lang['ms2_payment_bepaid_country_ec'] = 'Ecuador';
$_lang['ms2_payment_bepaid_country_gq'] = 'Equatorial Guinea';
$_lang['ms2_payment_bepaid_country_er'] = 'Eritrea';
$_lang['ms2_payment_bepaid_country_ee'] = 'Estonia';
$_lang['ms2_payment_bepaid_country_et'] = 'Ethiopia';
$_lang['ms2_payment_bepaid_country_za'] = 'South Africa';
$_lang['ms2_payment_bepaid_country_gs'] = 'South Georgia and the South Sandwich Islands';
$_lang['ms2_payment_bepaid_country_ss'] = 'Republic of South Sudan';
$_lang['ms2_payment_bepaid_country_jm'] = 'Jamaica';
$_lang['ms2_payment_bepaid_country_jp'] = 'Japan';
