<?php
$config['cache.driver'] = 'file';
$config['cache.name'] = [
    'subjects' => [
        'getAll' => 'allSubjects'
    ],
    'block' => [
        'getAll' => 'allBlocks'
    ],
    'class' => [
        'getAll' => 'allClasses'
    ]
];