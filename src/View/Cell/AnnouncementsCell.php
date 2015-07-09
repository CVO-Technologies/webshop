<?php

namespace Webshop\View\Cell;

use Cake\View\Cell;
use Croogo\Nodes\Model\Table\NodesTable;

/**
 * @property NodesTable Nodes
 */
class AnnouncementsCell extends Cell
{

    public function panelDashboard($limit = null)
    {
        $this->loadModel('Croogo/Nodes.Nodes');

        $announcements = $this->Nodes->find('announcements');
        if (!is_null($limit)) {
            $announcements->limit($limit);
        }

        $this->set(compact('announcements'));
    }

}
