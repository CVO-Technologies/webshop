<?php

class WebshopActivation
{

    public function beforeActivation(&$controller)
    {
        return true;
    }

    public function onActivation(&$controller)
    {
        $CroogoPlugin = new CroogoPlugin();
        $CroogoPlugin->migrate('Webshop');
    }

    public function beforeDeactivation(&$controller)
    {
        return true;
    }

    public function onDeactivation(&$controller)
    {
        $controller->Croogo->removeAco('Webshop');
    }
}
