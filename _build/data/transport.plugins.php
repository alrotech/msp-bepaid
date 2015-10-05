<?php

$plugins = [];

$list = [
    'mspBePaid' => [
        'description' => 'mspBePaid',
        'events' => [
            'OnManagerPageBeforeRender'
        ]
    ]
];

foreach ($list as $k => $v) {
    $plugin = new modPlugin($xpdo);
    $plugin->fromArray([
        'id' => 0,
        'name' => $k,
        'category' => 0,
        'description' => $v['description'],
        'plugincode' => trim(str_replace(['<?php', '?>'], '', file_get_contents($sources['plugins'] . $k . '.php'))),
        'static' => true,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/' . $k . '.php',
        'source' => 1,
        'property_preprocess' => 0,
        'editor_type' => 0,
        'cache_type' => 0
    ], '', true, true);
    if (!empty($v['events'])) {
        foreach ($v['events'] as $e) {
            $event = new modPluginEvent($xpdo);
            $event->fromArray([
                'pluginid' => 0,
                'event' => $e,
                'priority' => 0,
                'propertyset' => 0,
            ], '', true, true);
            $plugin->addOne($event, 'PluginEvents');
        }
        unset($v['events']);
    }
    $plugins[] = $plugin;
}

return $plugins;
