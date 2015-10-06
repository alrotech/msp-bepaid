<?php

switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':

        if ($_GET['a'] != 'system/settings') {
            return;
        }

        $ms2connector = $modx->getOption('minishop2.assets_url', null, $modx->getOption('assets_url') . 'components/minishop2/') . 'connector.php';

//        $modx->controller->addLexiconTopic('minishop2:default');
        $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/mspbepaid/js/mgr/bepaid.js');
        $modx->controller->addHtml('<script>BePaidPayment.ms2connector = "' . $ms2connector . '";</script>');

        $files = [
            'language.combo.js',
            'status.combo.js',
            'resource.combo.js',
            'readonly.combo.js',
//            'hidden.combo.js'
        ];

        foreach ($files as $file) {
            $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/mspbepaid/js/mgr/' . $file);
        }

        break;
}
