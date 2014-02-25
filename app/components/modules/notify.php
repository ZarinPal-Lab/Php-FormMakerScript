<?php
namespace app\components\modules;

abstract class Notify
{
    public $trans;
    public $controller;
    
    public function __construct($trans)
    {
        $this->controller = \Framework::instance()->controller;
        $this->trans = $trans;
    }
    
    abstract public function run();
}