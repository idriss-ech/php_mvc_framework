<?php

Class Controller{
    protected $_model; 
    protected $_controller;
    protected $_action;
    protected $_template;

    public function __construct($model, $controller, $action){
        $this->_model = $model; 
        $this->_controller = $controller; 
        $this->_action = $action;

        $this->_model = new $model;
        $this->_template = new Template($controller, $action);

    }
    
    public function set($name, $value){
        $this->_template->set($name, $value);
    }

    public function __destruct(){
        $this->_template->render();
    }

}