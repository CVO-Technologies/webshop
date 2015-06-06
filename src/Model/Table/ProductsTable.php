<?php

namespace Webshop\Model\Table;

use Cake\ORM\Table;
use Croogo\Croogo\Model\Table\CroogoTable;

class ProductsTable extends CroogoTable
{

    public $useDbConfig = 'nodes';

    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'This field cannot be left blank.',
        ),
        'slug' => array(
            'isUniquePerType' => array(
                'rule' => 'isUnique',
                'message' => 'This slug has already been taken.',
            ),
            'minLength' => array(
                'rule' => array('minLength', 1),
                'message' => 'Slug cannot be empty.',
            ),
        ),
    );

    public $actsAs = array(
        'Webshop.ConfigurableItem',
        'Webshop.ConfigurationValueHost',
        'Tree',
        'Croogo.BulkProcess' => array(
            'actionsMap' => array(
                'promote' => 'bulkPromote',
                'unpromote' => 'bulkUnpromote',
            ),
        ),
        'Croogo.Encoder',
        'Croogo.Publishable',
//		'Croogo.Trackable',
//		'Meta.Meta',
        'Croogo.Url' => array(
            'url' => array(
                'plugin' => 'webshop',
                'controller' => 'products',
                'action' => 'view',
            ),
            'fields' => array(),
            'pass' => array(
                'id'
            )
        ),
        'Search.Searchable',
        'Containable'
    );

    public $filterArgs = array(
        'q' => array('type' => 'query', 'method' => 'filterPublishedNodes'),
        'filter' => array('type' => 'query', 'method' => 'filterNodes'),
        'title' => array('type' => 'like'),
        'type' => array('type' => 'value'),
        'status' => array('type' => 'value'),
        'promote' => array('type' => 'value'),
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'Users.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
//		'Node' => array(
//			'className' => 'Nodes.Node',
//			'foreignKey' => 'id',
//		),
        'Tax' => array(
            'className' => 'WebshopTaxes.Tax',
            'foreignKey' => 'tax_id'
        ),
    );

    public $findMethods = array(
        'promoted' => true,
        'viewBySlug' => true,
        'viewById' => true,
        'published' => true,
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('NodesDatasource.NodeContentType', [
            'type' => 'product'
        ]);
        $this->addBehavior('Croogo/Croogo.Url', [
            'url' => array(
                'plugin' => 'Webshop',
                'controller' => 'Products',
                'action' => 'view',
            ),
            'fields' => [],
            'pass' => [
                'id'
            ]
        ]);
    }

    public function getPrice($productId, $configuration)
    {
        $product = $this->find('first', array(
            'conditions' => array(
                'id' => $productId
            ),
            'recursive' => 0
        ));

//		debug($product);

        return $product['CustomFields']['price'];

        $productConfigurationOptions = $this->ProductConfigurationOption->find('all', array(
            'conditions' => array(
                'product_id' => $productId
            ),
            'recursive' => -1
        ));

        debug($productConfigurationOptions);
    }

}
