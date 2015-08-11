<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;
use Croogo\Core\Model\Table\CroogoTable;

class ProductsTable extends CroogoTable
{

    public $useDbConfig = 'nodes';

    public $validate = [
        'title' => [
            'rule' => 'notEmpty',
            'message' => 'This field cannot be left blank.',
        ],
        'slug' => [
            'isUniquePerType' => [
                'rule' => 'isUnique',
                'message' => 'This slug has already been taken.',
            ],
            'minLength' => [
                'rule' => ['minLength', 1],
                'message' => 'Slug cannot be empty.',
            ],
        ],
    ];

    public $actsAs = [
        'Webshop.ConfigurableItem',
        'Webshop.ConfigurationValueHost',
        'Tree',
        'Croogo.BulkProcess' => [
            'actionsMap' => [
                'promote' => 'bulkPromote',
                'unpromote' => 'bulkUnpromote',
            ],
        ],
        'Croogo.Encoder',
        'Croogo.Publishable',
//		'Croogo.Trackable',
//		'Meta.Meta',
        'Croogo.Url' => [
            'url' => [
                'plugin' => 'webshop',
                'controller' => 'products',
                'action' => 'view',
            ],
            'fields' => [],
            'pass' => [
                'id'
            ]
        ],
        'Search.Searchable',
        'Containable'
    ];

    public $filterArgs = [
        'q' => ['type' => 'query', 'method' => 'filterPublishedNodes'],
        'filter' => ['type' => 'query', 'method' => 'filterNodes'],
        'title' => ['type' => 'like'],
        'type' => ['type' => 'value'],
        'status' => ['type' => 'value'],
        'promote' => ['type' => 'value'],
    ];

    public $belongsTo = [
        'User' => [
            'className' => 'Users.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
//		'Node' => array(
//			'className' => 'Nodes.Node',
//			'foreignKey' => 'id',
//		),
        'Tax' => [
            'className' => 'WebshopTaxes.Tax',
            'foreignKey' => 'tax_id'
        ],
    ];

    public $findMethods = [
        'promoted' => true,
        'viewBySlug' => true,
        'viewById' => true,
        'published' => true,
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('NodesDatasource.NodeContentType', [
            'type' => 'product'
        ]);
        $this->addBehavior('Croogo/Core.Url', [
            'url' => [
                'plugin' => 'Webshop',
                'controller' => 'Products',
                'action' => 'view',
            ],
            'fields' => [],
            'pass' => [
                'id'
            ]
        ]);
        $this->addBehavior('Webshop.ConfigurableItem');
        $this->addBehavior('Webshop.ConfigurationValueHost');
    }

//    public function getPrice($productId, $configuration)
//    {
//        $product = $this->find('first', array(
//            'conditions' => array(
//                'id' => $productId
//            ),
//            'recursive' => 0
//        ));
//
////		debug($product);
//
//        return $product['CustomFields']['price'];
//
//        $productConfigurationOptions = $this->ProductConfigurationOption->find('all', array(
//            'conditions' => array(
//                'product_id' => $productId
//            ),
//            'recursive' => -1
//        ));
//
//        debug($productConfigurationOptions);
//    }
}
