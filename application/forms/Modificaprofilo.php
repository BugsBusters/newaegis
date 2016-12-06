<?php

class Application_Form_Modificaprofilo extends Zend_Form
{

    public function init()
    {
        include_once("Lingua.php");
        $this->setMethod('post');
        $this->setName('modificaprofilo'); //setta name e id del form


        $this->addElement('text', 'nome', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Nome:',
            'placeholder' => 'Inserisci il tuo nome',
            'class' => 'form-control',
        ));

        $this->addElement('text', 'cognome', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Cognome:',
            'placeholder' => 'Inserisci il tuo cognome',
            'class' => 'form-control',
        ));


        $this->addElement('text', 'username', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'required' => true,
            'label' => 'Username:',
            'placeholder' => 'Inserisci il tuo username',
            'class' => 'form-control',
        ));

        $this->addElement('password', 'password', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'placeholder' => 'Inserisci la nuova password (lascia vuoto per non modificare)',
            'label' => 'Password:',
            'class' => 'form-control',
        ));
        $this->addElement('password', 'rpassword', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'placeholder' => 'Inserisci la password',
            'label' => 'Conferma la password:',
            'class' => 'form-control',
        ));


        $this->addElement('submit', 'Modifica', array(
            'class' => 'btn btn-rounded btn-inline btn-uliveto center-div',
            'label' => 'Modifica il tuo profilo'
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'a', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}