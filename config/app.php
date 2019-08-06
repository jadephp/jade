<?php
return [
    'db.options' => array(
        'driver' => 'pdo_mysql',
    ),
    'orm.em.options' => array(
        'mappings' => array(
            // Using actual filesystem paths
            array(
                'type' => 'annotation',
                'namespace' => 'Foo\Entities',
                'path' => __DIR__.'/src/Foo/Entities',
            ),
            array(
                'type' => 'xml',
                'namespace' => 'Bat\Entities',
                'path' => __DIR__.'/src/Bat/Resources/mappings',
            ),
        ),
    ),
];