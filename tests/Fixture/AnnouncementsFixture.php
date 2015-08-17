<?php

namespace Webshop\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AnnouncementsFixture extends TestFixture
{

    public $table = 'nodes';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20],
        'user_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20],
        'title' => ['type' => 'string', 'null' => false, 'default' => null],
        'slug' => ['type' => 'string', 'null' => false, 'default' => null],
        'body' => ['type' => 'text', 'null' => false, 'default' => null],
        'excerpt' => ['type' => 'text', 'null' => true, 'default' => null],
        'status' => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => '0'],
        'mime_type' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100],
        'comment_status' => ['type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1],
        'comment_count' => ['type' => 'integer', 'null' => true, 'default' => '0'],
        'promote' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
        'path' => ['type' => 'string', 'null' => false, 'default' => null],
        'terms' => ['type' => 'text', 'null' => true, 'default' => null],
        'sticky' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null],
        'visibility_roles' => ['type' => 'text', 'null' => true, 'default' => null],
        'type' => ['type' => 'string', 'null' => false, 'default' => 'node', 'length' => 100],
        'publish_start' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'publish_end' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'slug' => ['type' => 'unique', 'columns' => ['slug']]
        ],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 1,
            'parent_id' => null,
            'user_id' => 1,
            'title' => 'Hello World',
            'slug' => 'hello-world',
            'body' => '<p>Welcome to Croogo. This is your first post. You can edit or delete it from the admin panel.</p>',
            'excerpt' => '',
            'status' => 1,
            'mime_type' => '',
            'comment_status' => 2,
            'comment_count' => 1,
            'promote' => 1,
            'path' => '/blog/hello-world',
            'terms' => '{\"1\":\"uncategorized\"}',
            'sticky' => 0,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => '',
            'type' => 'blog',
            'updated' => '2009-12-25 11:00:00',
            'created' => '2009-12-25 11:00:00'
        ],
        [
            'id' => 2,
            'parent_id' => null,
            'user_id' => 1,
            'title' => 'Bla',
            'slug' => 'bla',
            'body' => 'A cool announcement',
            'excerpt' => '',
            'status' => 1,
            'mime_type' => '',
            'comment_status' => 2,
            'comment_count' => 1,
            'promote' => 1,
            'path' => '/announcement/bla',
            'terms' => '{\"1\":\"uncategorized\"}',
            'sticky' => 0,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => '',
            'type' => 'announcement',
            'updated' => '2009-12-25 11:00:00',
            'created' => '2009-12-25 11:00:00'
        ]
    ];
}
