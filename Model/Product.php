<?php

App::uses('WebshopAppModel', 'Webshop.Model');

class Product extends WebshopAppModel {

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
		'Meta.Meta',
		'Croogo.Url',
		'Croogo.Cached' => array(
			'groups' => array(
				'nodes',
			),
		),
		'Search.Searchable',
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
		'ProductConfigurationImplementation'
	);

	public $findMethods = array(
		'promoted' => true,
		'viewBySlug' => true,
		'viewById' => true,
		'published' => true,
	);

}
