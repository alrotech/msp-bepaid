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

// settings
$_lang['area_ms2_payment_bepaid'] = 'bePaid';

$_lang['setting_ms2_payment_bepaid_store_id'] = 'Идентификатор магазина в системе bePaid';
$_lang['setting_ms2_payment_bepaid_store_id_desc'] = 'Данный идентификатор создается при регистрации в системе bePaid и высылается в письме.';

$_lang['setting_ms2_payment_bepaid_secret_key'] = 'Секретный ключ';
$_lang['setting_ms2_payment_bepaid_secret_key_desc'] = 'Последовательность случайных символов, участвует в формировании электронной подписи заказа, выдается при регистрации магазина в системе bePaid.';

$_lang['setting_ms2_payment_bepaid_language'] = 'Язык bePaid';
$_lang['setting_ms2_payment_bepaid_language_desc'] = 'Выберите язык, на котором показывать сайт bePaid при оплате. По умолчанию будет использоваться язык, установленный для сайта в системной настройке cultureKey.';

$_lang['setting_ms2_payment_bepaid_country'] = 'Страна по умолчанию';
$_lang['setting_ms2_payment_bepaid_country_desc'] = 'Выберите страну, которая будет использоваться по умолчанию при совершении оплаты. Выбор страны можно переопределить через корзину. Рекомендуется выбирать страну, где расположен магазин.';

$_lang['setting_ms2_payment_bepaid_success_status'] = 'Статус заказа в случае успешной оплаты';
$_lang['setting_ms2_payment_bepaid_success_status_desc'] = 'Если заказ обработан без ошибок и со стороны банка транзакция авторизована, статус заказа будет изменен на указанный.';

$_lang['setting_ms2_payment_bepaid_failure_status'] = 'Статус заказа в случае ошибок оплаты';
$_lang['setting_ms2_payment_bepaid_failure_status_desc'] = 'Если заказ не обработан или были ошибки в процессе оплаты, статус заказа будет изменен на указанный.';

$_lang['setting_ms2_payment_bepaid_success_page'] = 'Страница успешной оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_success_page_desc'] = 'Пользователь будет отправлен на эту страницу после успешного завершения оплаты. Рекомендуется указать страницу с корзиной для вывода деталей заказа.';

$_lang['setting_ms2_payment_bepaid_failure_page'] = 'Страница отмены оплаты bePaid';
$_lang['setting_ms2_payment_bepaid_failure_page_desc'] = 'Пользователь будет отправлен на эту страницу при неудачной оплате. Рекомендуется указать страницу с корзиной для вывода деталей заказа.';

$_lang['setting_ms2_payment_bepaid_currency'] = 'Валюта платежа';
$_lang['setting_ms2_payment_bepaid_currency_desc'] = 'Буквенный трехзначный код валюты согласно <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">ISO 4271</a>.';

$_lang['setting_ms2_payment_bepaid_checkout_url'] = 'Входная точка API';
$_lang['setting_ms2_payment_bepaid_checkout_url_desc'] = 'URL, куда будут отправляться запросы на оплату.';

$_lang['setting_ms2_payment_bepaid_test_mode'] = 'Режим совершения тестовых платежей';
$_lang['setting_ms2_payment_bepaid_test_mode_desc'] = 'При значении "Да", все запросы оплаты будут отправляться на тестовую среду обработки платежей bePaid. Реальные карты в данном режиме не работают.';

$_lang['setting_ms2_payment_bepaid_readonly_fields'] = 'Свойства заказа только для чтения';
$_lang['setting_ms2_payment_bepaid_readonly_fields_desc'] = 'Поля заказа, перечисленные в данном параметре, на странице оплаты будут доступны только для чтения (редактировать нельзя). Список доступных полей (указывается через запятую): <b>email</b>, <b>first_name</b>, <b>last_name</b>, <b>address</b>, <b>city</b>, <b>state</b>, <b>zip</b>, <b>phone</b>, <b>country</b>.';

$_lang['setting_ms2_payment_bepaid_hidden_fields'] = 'Скрытые свойства заказа';
$_lang['setting_ms2_payment_bepaid_hidden_fields_desc'] = 'Поля заказа, перечисленные в данном параметре, будут скрыты на странице оплаты, но при это будут записаны в параметры платежа. Список доступных полей (указывается через запятую): <b>phone</b>, <b>address</b>.';

$_lang['setting_ms2_payment_bepaid_payment_types'] = 'Доступные способы оплаты';
$_lang['setting_ms2_payment_bepaid_payment_types_desc'] = 'Массив способов оплаты для отображения на странице оплаты. Доступны следующие значения: <b>credit_card</b>, <b>erip</b>, <b>halva</b>. Для ЕРИП так же необходимо указать значение <b>erip_service_id</b>.';

$_lang['setting_ms2_payment_bepaid_erip_service_id'] = 'Код услуги ЕРИП';
$_lang['setting_ms2_payment_bepaid_erip_service_id_desc'] = 'Уникальный код магазина или услуги, зарегистрированной для продавца в системе "Расчет". Для тестов используйте значение: <b>99999999</b>.';

$_lang['setting_ms2_payment_bepaid_api_version'] = 'Версия платежной страницы';
$_lang['setting_ms2_payment_bepaid_api_version_desc'] = 'На текущий момент актуальная версия протокола <b>2.1</b>. Если вы устанавливали компонент ранее, это значение следует обновить вручную.';

// countries
$_lang['ms2_payment_bepaid_country_au'] = 'Австралия';
$_lang['ms2_payment_bepaid_country_at'] = 'Австрия';
$_lang['ms2_payment_bepaid_country_az'] = 'Азербайджан';
$_lang['ms2_payment_bepaid_country_ax'] = 'Аландские острова';
$_lang['ms2_payment_bepaid_country_al'] = 'Албания';
$_lang['ms2_payment_bepaid_country_dz'] = 'Алжир';
$_lang['ms2_payment_bepaid_country_as'] = 'Американское Самоа';
$_lang['ms2_payment_bepaid_country_ai'] = 'Ангилья';
$_lang['ms2_payment_bepaid_country_ao'] = 'Ангола';
$_lang['ms2_payment_bepaid_country_ad'] = 'Андорра';
$_lang['ms2_payment_bepaid_country_aq'] = 'Антарктида';
$_lang['ms2_payment_bepaid_country_ag'] = 'Антигуа и Барбуда';
$_lang['ms2_payment_bepaid_country_ar'] = 'Аргентина';
$_lang['ms2_payment_bepaid_country_am'] = 'Армения';
$_lang['ms2_payment_bepaid_country_aw'] = 'Аруба';
$_lang['ms2_payment_bepaid_country_af'] = 'Афганистан';
$_lang['ms2_payment_bepaid_country_bs'] = 'Багамские острова';
$_lang['ms2_payment_bepaid_country_bd'] = 'Бангладеш';
$_lang['ms2_payment_bepaid_country_bb'] = 'Барбадос';
$_lang['ms2_payment_bepaid_country_bh'] = 'Бахрейн';
$_lang['ms2_payment_bepaid_country_by'] = 'Беларусь';
$_lang['ms2_payment_bepaid_country_bz'] = 'Белиз';
$_lang['ms2_payment_bepaid_country_be'] = 'Бельгия';
$_lang['ms2_payment_bepaid_country_bj'] = 'Бенин';
$_lang['ms2_payment_bepaid_country_bm'] = 'Бермудские острова';
$_lang['ms2_payment_bepaid_country_bg'] = 'Болгария';
$_lang['ms2_payment_bepaid_country_bo'] = 'Боливия';
$_lang['ms2_payment_bepaid_country_bq'] = 'Бона́йре, Синт-Эста́тиус и Са́ба';
$_lang['ms2_payment_bepaid_country_ba'] = 'Босния и Герцеговина';
$_lang['ms2_payment_bepaid_country_bw'] = 'Ботсвана';
$_lang['ms2_payment_bepaid_country_br'] = 'Бразилия';
$_lang['ms2_payment_bepaid_country_io'] = 'Британские территории в Индийском океане';
$_lang['ms2_payment_bepaid_country_bn'] = 'Бруней-Даруссалам';
$_lang['ms2_payment_bepaid_country_bf'] = 'Буркина Фасо';
$_lang['ms2_payment_bepaid_country_bi'] = 'Бурунди';
$_lang['ms2_payment_bepaid_country_bt'] = 'Бутан';
$_lang['ms2_payment_bepaid_country_vu'] = 'Вануату';
$_lang['ms2_payment_bepaid_country_gb'] = 'Великобритания';
$_lang['ms2_payment_bepaid_country_hu'] = 'Венгрия';
$_lang['ms2_payment_bepaid_country_ve'] = 'Венесуэла';
$_lang['ms2_payment_bepaid_country_vg'] = 'Виргинские острова, Британские';
$_lang['ms2_payment_bepaid_country_vi'] = 'Виргинские острова, США';
$_lang['ms2_payment_bepaid_country_um'] = 'Внешние малые острова (США)';
$_lang['ms2_payment_bepaid_country_vn'] = 'Вьетнам';
$_lang['ms2_payment_bepaid_country_ga'] = 'Габон';
$_lang['ms2_payment_bepaid_country_ht'] = 'Гаити';
$_lang['ms2_payment_bepaid_country_gy'] = 'Гайана';
$_lang['ms2_payment_bepaid_country_gm'] = 'Гамбия';
$_lang['ms2_payment_bepaid_country_gh'] = 'Гана';
$_lang['ms2_payment_bepaid_country_gp'] = 'Гваделупа';
$_lang['ms2_payment_bepaid_country_gt'] = 'Гватемала';
$_lang['ms2_payment_bepaid_country_gn'] = 'Гвинея';
$_lang['ms2_payment_bepaid_country_gw'] = 'Гвинея-Бисау';
$_lang['ms2_payment_bepaid_country_de'] = 'Германия';
$_lang['ms2_payment_bepaid_country_gg'] = 'Гернси';
$_lang['ms2_payment_bepaid_country_gi'] = 'Гибралтар';
$_lang['ms2_payment_bepaid_country_hn'] = 'Гондурас';
$_lang['ms2_payment_bepaid_country_hk'] = 'Гонконг';
$_lang['ms2_payment_bepaid_country_gd'] = 'Гренада';
$_lang['ms2_payment_bepaid_country_gl'] = 'Гренландия';
$_lang['ms2_payment_bepaid_country_gr'] = 'Греция';
$_lang['ms2_payment_bepaid_country_ge'] = 'Грузия';
$_lang['ms2_payment_bepaid_country_gu'] = 'Гуам';
$_lang['ms2_payment_bepaid_country_dk'] = 'Дания';
$_lang['ms2_payment_bepaid_country_je'] = 'Джерси';
$_lang['ms2_payment_bepaid_country_dj'] = 'Джибути';
$_lang['ms2_payment_bepaid_country_dm'] = 'Доминика';
$_lang['ms2_payment_bepaid_country_do'] = 'Доминиканская Республика';
$_lang['ms2_payment_bepaid_country_eg'] = 'Египет';
$_lang['ms2_payment_bepaid_country_zm'] = 'Замбия';
$_lang['ms2_payment_bepaid_country_eh'] = 'Западная Сахара';
$_lang['ms2_payment_bepaid_country_zw'] = 'Зимбабве';
$_lang['ms2_payment_bepaid_country_il'] = 'Израиль';
$_lang['ms2_payment_bepaid_country_in'] = 'Индия';
$_lang['ms2_payment_bepaid_country_id'] = 'Индонезия';
$_lang['ms2_payment_bepaid_country_jo'] = 'Иордания';
$_lang['ms2_payment_bepaid_country_iq'] = 'Ирак';
$_lang['ms2_payment_bepaid_country_ir'] = 'Иран, Исламская Республика';
$_lang['ms2_payment_bepaid_country_ie'] = 'Ирландия';
$_lang['ms2_payment_bepaid_country_is'] = 'Исландия';
$_lang['ms2_payment_bepaid_country_es'] = 'Испания';
$_lang['ms2_payment_bepaid_country_it'] = 'Италия';
$_lang['ms2_payment_bepaid_country_ye'] = 'Йемен';
$_lang['ms2_payment_bepaid_country_cv'] = 'Кабо-Верде';
$_lang['ms2_payment_bepaid_country_kz'] = 'Казахстан';
$_lang['ms2_payment_bepaid_country_ky'] = 'Каймановы острова';
$_lang['ms2_payment_bepaid_country_kh'] = 'Камбоджа';
$_lang['ms2_payment_bepaid_country_cm'] = 'Камерун';
$_lang['ms2_payment_bepaid_country_ca'] = 'Канада';
$_lang['ms2_payment_bepaid_country_qa'] = 'Катар';
$_lang['ms2_payment_bepaid_country_ke'] = 'Кения';
$_lang['ms2_payment_bepaid_country_cy'] = 'Кипр';
$_lang['ms2_payment_bepaid_country_ki'] = 'Кирибати';
$_lang['ms2_payment_bepaid_country_cn'] = 'Китай';
$_lang['ms2_payment_bepaid_country_cc'] = 'Кокосовы острова';
$_lang['ms2_payment_bepaid_country_co'] = 'Колумбия';
$_lang['ms2_payment_bepaid_country_km'] = 'Коморские острова';
$_lang['ms2_payment_bepaid_country_cg'] = 'Конго';
$_lang['ms2_payment_bepaid_country_cd'] = 'Конго, Демократическая Республика';
$_lang['ms2_payment_bepaid_country_kp'] = 'Корейская Народно-Демократическая Республика';
$_lang['ms2_payment_bepaid_country_cr'] = 'Коста-Рика';
$_lang['ms2_payment_bepaid_country_ci'] = 'Кот-д’Ивуар';
$_lang['ms2_payment_bepaid_country_cu'] = 'Куба';
$_lang['ms2_payment_bepaid_country_kw'] = 'Кувейт';
$_lang['ms2_payment_bepaid_country_kg'] = 'Кыргызстан';
$_lang['ms2_payment_bepaid_country_cw'] = 'Кюрасао';
$_lang['ms2_payment_bepaid_country_la'] = 'Лаосская Народно-Демократическая Республика';
$_lang['ms2_payment_bepaid_country_lv'] = 'Латвия';
$_lang['ms2_payment_bepaid_country_ls'] = 'Лесото';
$_lang['ms2_payment_bepaid_country_lr'] = 'Либерия';
$_lang['ms2_payment_bepaid_country_lb'] = 'Ливан';
$_lang['ms2_payment_bepaid_country_ly'] = 'Ливия';
$_lang['ms2_payment_bepaid_country_lt'] = 'Литва';
$_lang['ms2_payment_bepaid_country_li'] = 'Лихтенштейн';
$_lang['ms2_payment_bepaid_country_lu'] = 'Люксембург';
$_lang['ms2_payment_bepaid_country_mu'] = 'Маврикий';
$_lang['ms2_payment_bepaid_country_mr'] = 'Мавритания';
$_lang['ms2_payment_bepaid_country_mg'] = 'Мадагаскар';
$_lang['ms2_payment_bepaid_country_yt'] = 'Майотта';
$_lang['ms2_payment_bepaid_country_mo'] = 'Макао';
$_lang['ms2_payment_bepaid_country_mk'] = 'Македония, Республика';
$_lang['ms2_payment_bepaid_country_mw'] = 'Малави';
$_lang['ms2_payment_bepaid_country_my'] = 'Малайзия';
$_lang['ms2_payment_bepaid_country_ml'] = 'Мали';
$_lang['ms2_payment_bepaid_country_mv'] = 'Мальдивы';
$_lang['ms2_payment_bepaid_country_mt'] = 'Мальта';
$_lang['ms2_payment_bepaid_country_ma'] = 'Марокко';
$_lang['ms2_payment_bepaid_country_mq'] = 'Мартиника';
$_lang['ms2_payment_bepaid_country_mh'] = 'Маршалловы острова';
$_lang['ms2_payment_bepaid_country_mx'] = 'Мексика';
$_lang['ms2_payment_bepaid_country_fm'] = 'Микронезия, Федеративные Штаты';
$_lang['ms2_payment_bepaid_country_mz'] = 'Мозамбик';
$_lang['ms2_payment_bepaid_country_md'] = 'Молдова';
$_lang['ms2_payment_bepaid_country_mc'] = 'Монако';
$_lang['ms2_payment_bepaid_country_mn'] = 'Монголия';
$_lang['ms2_payment_bepaid_country_ms'] = 'Монтсеррат';
$_lang['ms2_payment_bepaid_country_mm'] = 'Мьянма';
$_lang['ms2_payment_bepaid_country_na'] = 'Намибия';
$_lang['ms2_payment_bepaid_country_nr'] = 'Науру';
$_lang['ms2_payment_bepaid_country_np'] = 'Непал';
$_lang['ms2_payment_bepaid_country_ne'] = 'Нигер';
$_lang['ms2_payment_bepaid_country_ng'] = 'Нигерия';
$_lang['ms2_payment_bepaid_country_nl'] = 'Нидерланды';
$_lang['ms2_payment_bepaid_country_ni'] = 'Никарагуа';
$_lang['ms2_payment_bepaid_country_nu'] = 'Ниуэ';
$_lang['ms2_payment_bepaid_country_nz'] = 'Новая Зеландия';
$_lang['ms2_payment_bepaid_country_nc'] = 'Новая Каледония';
$_lang['ms2_payment_bepaid_country_no'] = 'Норвегия';
$_lang['ms2_payment_bepaid_country_ae'] = 'Объединенные Арабские Эмираты';
$_lang['ms2_payment_bepaid_country_om'] = 'Оман';
$_lang['ms2_payment_bepaid_country_bv'] = 'Остров Буве';
$_lang['ms2_payment_bepaid_country_im'] = 'Остров Мэн';
$_lang['ms2_payment_bepaid_country_nf'] = 'Остров Норфолк';
$_lang['ms2_payment_bepaid_country_sh'] = 'Остров Святой Елены';
$_lang['ms2_payment_bepaid_country_hm'] = 'Остров Херд и острова Макдональд';
$_lang['ms2_payment_bepaid_country_ck'] = 'Острова Кука';
$_lang['ms2_payment_bepaid_country_cx'] = 'Острова Рождества';
$_lang['ms2_payment_bepaid_country_tc'] = 'Острова Теркс и Кайкос';
$_lang['ms2_payment_bepaid_country_pk'] = 'Пакистан';
$_lang['ms2_payment_bepaid_country_pw'] = 'Палау';
$_lang['ms2_payment_bepaid_country_ps'] = 'Палестинские территории';
$_lang['ms2_payment_bepaid_country_pa'] = 'Панама';
$_lang['ms2_payment_bepaid_country_pg'] = 'Папуа-Новая Гвинея';
$_lang['ms2_payment_bepaid_country_py'] = 'Парагвай';
$_lang['ms2_payment_bepaid_country_pe'] = 'Перу';
$_lang['ms2_payment_bepaid_country_pn'] = 'Питкэрн';
$_lang['ms2_payment_bepaid_country_pl'] = 'Польша';
$_lang['ms2_payment_bepaid_country_pt'] = 'Португалия';
$_lang['ms2_payment_bepaid_country_kr'] = 'Республика Корея';
$_lang['ms2_payment_bepaid_country_re'] = 'Реюньон';
$_lang['ms2_payment_bepaid_country_ru'] = 'Российская Федерация';
$_lang['ms2_payment_bepaid_country_rw'] = 'Руанда';
$_lang['ms2_payment_bepaid_country_ro'] = 'Румыния';
$_lang['ms2_payment_bepaid_country_sv'] = 'Сальвадор';
$_lang['ms2_payment_bepaid_country_ws'] = 'Самоа';
$_lang['ms2_payment_bepaid_country_sm'] = 'Сан-Марино';
$_lang['ms2_payment_bepaid_country_st'] = 'Сан-Томе и Принсипи';
$_lang['ms2_payment_bepaid_country_sa'] = 'Саудовская Аравия';
$_lang['ms2_payment_bepaid_country_sz'] = 'Свазиленд';
$_lang['ms2_payment_bepaid_country_va'] = 'Святой Престол (Государство-город Ватикан)';
$_lang['ms2_payment_bepaid_country_mp'] = 'Северные Марианские острова';
$_lang['ms2_payment_bepaid_country_sc'] = 'Сейшельские острова';
$_lang['ms2_payment_bepaid_country_bl'] = 'Сен-Бартельми';
$_lang['ms2_payment_bepaid_country_mf'] = 'Сен-Мартен (Французская часть)';
$_lang['ms2_payment_bepaid_country_pm'] = 'Сен-Пьер и Микелон';
$_lang['ms2_payment_bepaid_country_sn'] = 'Сенегал';
$_lang['ms2_payment_bepaid_country_vc'] = 'Сент-Винсент и Гренадины';
$_lang['ms2_payment_bepaid_country_kn'] = 'Сент-Китс и Невис';
$_lang['ms2_payment_bepaid_country_lc'] = 'Сент-Люсия';
$_lang['ms2_payment_bepaid_country_rs'] = 'Сербия';
$_lang['ms2_payment_bepaid_country_sg'] = 'Сингапур';
$_lang['ms2_payment_bepaid_country_sx'] = 'Синт-Маартен (Голландская часть)';
$_lang['ms2_payment_bepaid_country_sy'] = 'Сирия';
$_lang['ms2_payment_bepaid_country_sk'] = 'Словакия';
$_lang['ms2_payment_bepaid_country_si'] = 'Словения';
$_lang['ms2_payment_bepaid_country_us'] = 'Соединенные Штаты Америки';
$_lang['ms2_payment_bepaid_country_sb'] = 'Соломоновы Острова';
$_lang['ms2_payment_bepaid_country_so'] = 'Сомали';
$_lang['ms2_payment_bepaid_country_sd'] = 'Судан';
$_lang['ms2_payment_bepaid_country_sr'] = 'Суринам';
$_lang['ms2_payment_bepaid_country_sl'] = 'Сьерра-Леоне';
$_lang['ms2_payment_bepaid_country_tj'] = 'Таджикистан';
$_lang['ms2_payment_bepaid_country_th'] = 'Таиланд';
$_lang['ms2_payment_bepaid_country_tw'] = 'Тайвань';
$_lang['ms2_payment_bepaid_country_tz'] = 'Танзания, Объединенная Республика';
$_lang['ms2_payment_bepaid_country_tl'] = 'Тимор-Лешти';
$_lang['ms2_payment_bepaid_country_tg'] = 'Того';
$_lang['ms2_payment_bepaid_country_tk'] = 'Токелау';
$_lang['ms2_payment_bepaid_country_to'] = 'Тонга';
$_lang['ms2_payment_bepaid_country_tt'] = 'Тринидад и Тобаго';
$_lang['ms2_payment_bepaid_country_tv'] = 'Тувалу';
$_lang['ms2_payment_bepaid_country_tn'] = 'Тунис';
$_lang['ms2_payment_bepaid_country_tm'] = 'Туркменистан';
$_lang['ms2_payment_bepaid_country_tr'] = 'Турция';
$_lang['ms2_payment_bepaid_country_ug'] = 'Уганда';
$_lang['ms2_payment_bepaid_country_uz'] = 'Узбекистан';
$_lang['ms2_payment_bepaid_country_ua'] = 'Украина';
$_lang['ms2_payment_bepaid_country_wf'] = 'Уоллис и Футуна';
$_lang['ms2_payment_bepaid_country_uy'] = 'Уругвай';
$_lang['ms2_payment_bepaid_country_fo'] = 'Фарерские острова';
$_lang['ms2_payment_bepaid_country_fj'] = 'Фиджи';
$_lang['ms2_payment_bepaid_country_ph'] = 'Филиппины';
$_lang['ms2_payment_bepaid_country_fi'] = 'Финляндия';
$_lang['ms2_payment_bepaid_country_fk'] = 'Фолклендские (Мальвинские) острова';
$_lang['ms2_payment_bepaid_country_fr'] = 'Франция';
$_lang['ms2_payment_bepaid_country_gf'] = 'Французская Гвиана';
$_lang['ms2_payment_bepaid_country_pf'] = 'Французская Полинезия';
$_lang['ms2_payment_bepaid_country_tf'] = 'Французские Южные территории';
$_lang['ms2_payment_bepaid_country_hr'] = 'Хорватия';
$_lang['ms2_payment_bepaid_country_cf'] = 'Центрально-Африканская республика';
$_lang['ms2_payment_bepaid_country_td'] = 'Чад';
$_lang['ms2_payment_bepaid_country_me'] = 'Черногория';
$_lang['ms2_payment_bepaid_country_cz'] = 'Чешская республика';
$_lang['ms2_payment_bepaid_country_cl'] = 'Чили';
$_lang['ms2_payment_bepaid_country_ch'] = 'Швейцария';
$_lang['ms2_payment_bepaid_country_se'] = 'Швеция';
$_lang['ms2_payment_bepaid_country_sj'] = 'Шпицберген и Ян-Майен';
$_lang['ms2_payment_bepaid_country_lk'] = 'Шри Ланка';
$_lang['ms2_payment_bepaid_country_ec'] = 'Эквадор';
$_lang['ms2_payment_bepaid_country_gq'] = 'Экваториальная Гвинея';
$_lang['ms2_payment_bepaid_country_er'] = 'Эритрея';
$_lang['ms2_payment_bepaid_country_ee'] = 'Эстония';
$_lang['ms2_payment_bepaid_country_et'] = 'Эфиопия';
$_lang['ms2_payment_bepaid_country_za'] = 'ЮАР';
$_lang['ms2_payment_bepaid_country_gs'] = 'Южная Джорджия и Южные Сандвичевы острова';
$_lang['ms2_payment_bepaid_country_ss'] = 'Южный Судан, Республика';
$_lang['ms2_payment_bepaid_country_jm'] = 'Ямайка';
$_lang['ms2_payment_bepaid_country_jp'] = 'Япония';
