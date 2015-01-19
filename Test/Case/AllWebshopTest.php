<?php
/**
 * All Webshop plugin tests
 */
class AllWebshopTest extends CakeTestCase {

/**
 * Suite define the tests for this plugin
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Webshop test');

		$path = CakePlugin::path('Webshop') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
