<?php

$config['domparser']['links'] = [
    [
        'name' => 'Dom-Parsers',
        'icon' => 'bi.activity',
        'route' => 'laravia.domparser.list',
        'sort' => 10
    ]
];

$config['domparser']['commands'] = [
    'Laravia\Domparser\App\Console\Commands\DomparserParseCommand',
];

$config['domparser']['schedules'] = [
    [
        'laravia:domparser:parse',
        '* * * * *'
    ],
];
