<?php

switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':

        if ($_GET['a'] != 'system/settings') {
            return;
        }

        $files = [
            'bepaid.js',
            'language.combo.js',
            'readonly.combo.js',
            'hidden.combo.js'
        ];

        foreach ($files as $file) {
            $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/mspbepaid/js/mgr/' . $file);
        }

        break;
}
