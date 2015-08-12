<?php

namespace Webshop\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Croogo\Nodes\Model\Table\NodesTable;

class AnnouncementsBehaviorTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.announcements',
    ];

    /**
     * @var NodesTable
     */
    public $Nodes;

    public function setUp()
    {
        parent::setUp();

        $this->Nodes = TableRegistry::get('Croogo/Nodes.Nodes');

        $_SESSION = [];
    }

    public function testFindAnnouncements()
    {
        $this->Nodes->addBehavior('Webshop.Announcements');

        $this->assertEquals(1, $this->Nodes->find('announcements')->count());
    }
}
