<?php
class Template {
    protected $variables = array();
    protected $_controller;
    protected $_action;
    // Constructor to set controller and action
    function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }
    /** Set Template Variables **/
    function set($name, $value) {
        $this->variables[$name] = $value;
    }
    /** Render the Template **/
    function render() {
        $this->includeFile('header');
        $this->includeFile($this->_action);
        $this->includeFile('footer');
    }
    private function includeFile($file) {
        $filePath = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $file . '.php';
        extract($this->variables);
        if (file_exists($filePath)) {
            include $filePath;
        } else {
            include ROOT . DS . 'application' . DS . 'views' . DS . $file . '.php';
        }
    }
}