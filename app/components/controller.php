<?php
namespace app\components;
use framework\core\Controller as BaseController;
use framework\helpers\Html;
use framework\database\Database;

class Controller extends BaseController
{
    public function init()
    {
        $options = Database::queryBuilder()->select('*')->from('option')->getAll();
        
        foreach($options as $option) {
            $this->{$option->optionName} = $option->optionValue;
        }
    }
    
    public function priceField($priceType, $priceValue, $class = 'form-control',$id = 'price')
    {        
        if($priceType == 'select') {
            $options = explode(',', $priceValue);
            $options = array_combine($options, $options);
            $output = Html::dropDownList('price', $options, ['id' => $id,'class' => $class]);
        } elseif($priceType == 'text') {
            $output = Html::textField('price', ['value' => $priceValue,'id' => $id,'class' => $class,'disabled'=>'disabled']);
        }
        return $output;
    }
    
    public function randomCode($length, $encode = false)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmopqrstuvwxyz123456789';
        
        $output = '';
        for($i=0; $i<=$length; $i++) {
            $output .= $chars[rand(0,strlen($chars)-1)];
        }
        
        if($encode) {
            $output = substr(md5($output), 0, $length);
        }
        return $output;
    }

    public function date($timestamp)
    {
           \Framework::import(BASEPATH.'app/extensions/jdf/jdf',true);
           return jdate('Y-m-d - H:i:s',$timestamp,'','','en');
    }

    public function sendEmail($to,$subject,$message)
    {
       \Framework::import(BASEPATH.'app/extensions/phpmailer/phpmailer',true);

       $mailer = new \PHPMailer();
       $mailer->isSMTP();
       $mailer->isHTML();
       $mailer->CharSet = 'UTF8';
       $mailer->SMTPAuth = true;
       $mailer->Host = $this->smtpHost;
       $mailer->Username = $this->smtpUserName;
       $mailer->Password = $this->smtpPassword;
       $mailer->SMTPSecure = $this->smtpSecure;
       $mailer->Port = $this->smtpPort;
       $mailer->From = $this->smtpUserName;

       foreach($to as $email)
              $mailer->AddBCC($email);

       $mailer->Subject = $subject;
       $mailer->msgHTML($message);

       ob_start();
       $flag = true;
       if(!$mailer->Send())
              $flag = false;
       ob_end_clean();

       return $flag;
    }
}