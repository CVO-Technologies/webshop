<?php

namespace Webshop\Model\Behavior;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;

class StatusBehavior extends Behavior
{

    /**
     * Changes the status of a particular entity
     *
     * @param Entity $entity Entity to change the status of
     * @param string $status Status to change to
     * @param bool|false $force To force yes or no
     *
     * @return bool|\Cake\Datasource\EntityInterface|Entity
     */
    public function changeStatus(Entity $entity, $status, $force = false)
    {
        if ($force !== true) {
            if ($entity->status === $status) {
                Log::write(
                    LOG_WARNING,
                    __d(
                        'webshop',
                        'The status of {0} with id {1} is already set to {3}. Not making a change',
                        strtolower(Inflector::humanize($entity->source())),
                        $entity->id,
                        $status
                    ),
                    ['webshop']
                );

                return false;
            }
        } else {
            Log::write(
                LOG_WARNING,
                __d(
                    'webshop',
                    'Status change of {0} with id {1} is being forced to {3}',
                    strtolower(Inflector::humanize($entity->source())),
                    $entity->id,
                    $status
                ),
                ['webshop']
            );
        }

        $entity->status = $status;
        $entity = $this->_table->save($status);

        Log::write(
            LOG_INFO,
            __d(
                'webshop',
                'Changed status of {0} with id {1} to {3}',
                strtolower(Inflector::humanize($entity->source())),
                $entity->id,
                $status
            ),
            ['webshop']
        );

        $eventData = [];
        $eventData[$entity->source()]['entity'] = $entity;
        $eventData[$entity->source()]['status'] = $status;

        $overallEvent = new Event($entity->source() . '.statusChanged', $this, $eventData);
        $specificEvent = new Event($entity->source() . '.statusChangedTo' . Inflector::camelize($status), $this, $eventData);
        EventManager::instance()->dispatch($overallEvent);
        EventManager::instance()->dispatch($specificEvent);

        return $entity;
    }
}
