<?php

namespace Webshop\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class AnnouncementsBehavior extends Behavior {

    public function findAnnouncements(Query $query)
    {
        return $query->where(['type' => 'announcement']);
    }

}
