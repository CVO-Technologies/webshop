<?php

namespace Webshop\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Table;

trait ItemContainerTrait
{

    public function items()
    {
        return $this->items;
    }

    public function duplicateItemContainer(Entity $itemContainer, Table $table)
    {
        if (!in_array('Webshop\Model\Entity\ItemContainerTrait', class_uses($itemContainer))) {
            throw new \InvalidArgumentException();
        }

        /** @var ItemContainerTrait $itemContainer */

        $this->items = [];

        /** @var ConfigurableItemTrait $sourceItem */
        foreach ($itemContainer->items() as $sourceItem) {
            /** @var ConfigurableItemTrait $item */
            $item = $table->newEntity();

            $item->applyConfiguration($sourceItem);

            $this->items[] = $item;
        }

        debug($this);
    }

}
