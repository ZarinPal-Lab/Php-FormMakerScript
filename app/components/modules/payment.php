<?php
namespace app\components\modules;
use framework\database\Database;

abstract class Payment
{
    public $trans;
    public $callbackUrl;
    public $controller;
    
    public function __construct($trans)
    {
        $this->trans = $trans;
        $this->callbackUrl = \Framework::createUrl('request/callback',['au' => $this->trans->transAu]);
        $this->controller = \Framework::instance()->controller;
    }
    
    public function updateGatewayAu($gatewayAu)
    {
        $fields = [
            'transGatewayAu' => ':gau',
        ];
        $params = [
            ':gau' => $gatewayAu,
            ':tau' => $this->trans->transAu,
        ];
        return Database::queryBuilder()->update('trans',$fields,'transAu = :tau',$params);
    }
    
    public function updateTrans($gatewayAu)
    {
        $fields = [
            'transGatewayAu' => ':gau',
            'transStatus' => 1,
        ];
        $params = [
            ':gau' => $gatewayAu,
            ':tau' => $this->trans->transAu,
        ];
        return Database::queryBuilder()->update('trans',$fields,'transAu = :tau',$params);
    }
    
    public function getRial($price)
    {
        return ($price)*10;
    }
    
    public function setFlash($flash,$message)
    {
        \framework\session\Session::instance()->setFlash($flash,$message);
    }
    
    abstract public function gateway();
    
    abstract public function callback();
}