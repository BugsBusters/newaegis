<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDbParms()
    {

        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'my_aegis',
            'charset' => 'utf8'
        ));
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }

    protected function _initDefaultModuleAutoloader()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('App_');
        $this->getResourceLoader()
            ->addResourceType('modelResource','models/resources','Resource');
    }

    protected function _initFrontControllerPlugin()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new App_Controller_Plugin_Acl());
    }
}

