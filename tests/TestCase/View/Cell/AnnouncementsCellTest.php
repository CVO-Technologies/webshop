<?php

namespace Webshop\TestCase\View\Cell;

use Cake\ORM\Query;
use Cake\TestSuite\TestCase;
use Cake\View\CellTrait;
use Cake\View\View;

class AnnouncementsCellTest extends TestCase
{

    public $fixtures = [
        'plugin.webshop.announcements',
    ];

    /**
     * @var View
     */
    public $View;

    public function setUp()
    {
        parent::setUp();

        $request = $this->getMock('Cake\Network\Request');
        $response = $this->getMock('Cake\Network\Response');

        $this->View = new \Cake\View\View($request, $response);

        $_SESSION = [];
    }


    public function testPanelDashboards()
    {
        $cell = $this->View->cell('Webshop.Announcements::panelDashboard');

        $this->assertInstanceOf('\Webshop\View\Cell\AnnouncementsCell', $cell);
        $this->assertArrayHasKey('announcements', $cell->viewVars);

        /* @var array $announcements */
        $announcements = $cell->viewVars['announcements']->toArray();

        $this->assertEquals(1, count($announcements));
    }

    public function testPanelDashboardsWithLimit()
    {
        $cell = $this->View->cell('Webshop.Announcements::panelDashboard', [
            'limit' => 10
        ]);

        $this->assertInstanceOf('\Webshop\View\Cell\AnnouncementsCell', $cell);
        $this->assertArrayHasKey('announcements', $cell->viewVars);

        /* @var array $announcements */
        $announcements = $cell->viewVars['announcements']->toArray();

        $this->assertEquals(1, count($announcements));
    }
}
