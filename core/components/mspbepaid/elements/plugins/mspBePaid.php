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
 * @param modX $modx
 * @param $files
 */
function loadExtraJs($modx, $files) {
    $ms2connector = $modx->getOption('minishop2.assets_url', null, $modx->getOption('assets_url') . 'components/minishop2/') . 'connector.php';
    $ownConnector = $modx->getOption('assets_url') . 'components/mspbepaid/connector.php';

    $modx->controller->addLexiconTopic('minishop2:default');
    $modx->controller->addLexiconTopic('core:propertyset');
    $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/mspbepaid/js/mgr/bepaid.js');
    $modx->controller->addHtml('<script>BePaidPayment.ms2Connector = "' . $ms2connector . '";</script>');
    $modx->controller->addHtml('<script>BePaidPayment.ownConnector = "' . $ownConnector . '";</script>');

    foreach ($files as $file) {
        $modx->controller->addLastJavascript(MODX_ASSETS_URL . 'components/mspbepaid/js/mgr/' . $file);
    }
}

switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':

        switch ($_GET['a']) {
            case 'system/settings':
                loadExtraJs($modx, [
                    'language.combo.js',
                    'country.combo.js',
                    'status.combo.js',
                    'resource.combo.js',
                    // for now I have troubles with integrate superboxselect type into system settings grid
                    // so special types not used
                    // 'readonly.combo.js',
                    // 'visible.combo.js'
                ]); break;
            case 'mgr/settings':
                loadExtraJs($modx, [
                    'language.combo.js',
                    'country.combo.js',
                    'status.combo.js',
                    'resource.combo.js',
                    'settings.combo.js',
                    'property.window.js',
                    'properties.grid.js',
                    'properties.tab.js'
                ]);
                break;
        }
        break;
}
