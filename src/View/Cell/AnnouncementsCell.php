<?php

namespace Webshop\View\Cell;

use Cake\View\Cell;
use Croogo\Nodes\Model\Table\NodesTable;

/**
 * @property NodesTable Nodes
 */
class AnnouncementsCell extends Cell
{

    public function display()
    {
        $this->loadModel('Croogo/Nodes.Nodes');

        $announcements = $this->Nodes->find('announcements');

        $this->set(compact('announcements'));
    }

}
