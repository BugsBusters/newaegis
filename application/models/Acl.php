<?php

/**
 * Developer:   Andrea Civita
 * Web-site:    http://www.andreacivita.it
 * GitHub:      https://github.com/andreacivita/
 */

class Application_Model_Acl extends Zend_Acl
{
	public function __construct()
	{

		$this->addRole(new Zend_Acl_Role('guest'))
			 ->add(new Zend_Acl_Resource('index'))
            ->add(new Zend_Acl_Resource('error'))
			 ->add(new Zend_Acl_Resource('login'))
			 ->allow('guest', array('error','index','login'));

        $this->addRole(new Zend_Acl_Role('user'),'guest')
            ->add(new Zend_Acl_Resource('user'))
            ->allow('user', array('user'));

		$this->addRole(new Zend_Acl_Role('admin'), 'user')
			->add(new Zend_Acl_Resource('admin'))
			->allow('admin','admin');
	}
}