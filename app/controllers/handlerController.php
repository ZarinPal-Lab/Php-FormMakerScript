<?php
namespace app\controllers;
use app\components\Controller;

class HandlerController extends Controller
{
    public function error ($errNo, $errStr, $errFile, $errLine)
    {
        $this->render('handler/error', 
            [
                'errNo' => $errNo,
                'errStr' => $errStr,
                'errFile' => $errFile,
                'errLine' => $errLine
            ]
        );
    }

    public function exception ($exception)
    {
        $this->render('handler/exception', 
            [
                'exception' => $exception
            ]
        );
    }
}