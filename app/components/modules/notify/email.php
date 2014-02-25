<?php
namespace app\components\modules\notify;
use app\components\modules\Notify;
use framework\log\Log;

class Email extends Notify
{
    const TITLE = 'گذارش تراکنش موفق با شماره {ID}';

    const MESSAGE = '<p style="direction:rtl;font:12px tahoma;">گذارش تراکنش با شماره <b>{ID}</b> و کد پیگیری از سایت <b>{AU}</b> و کد پیگیری از درگاه <b>{GAU}</b> و مبلغ <b>{PRICE} تومان</b> در تاریخ <b>{DATE}</b> با موفقیت پرداخت شد</p>';
    
    public function run()
    {
        \Framework::import(BASEPATH.'app/extensions/jdf/jdf',true);

        $to = [
              $this->controller->adminMail,
              $this->trans->saveEmail,
        ];

        $subject = str_replace('{ID}',$this->trans->transId,self::TITLE);

        $find = ['{ID}','{AU}','{GAU}','{PRICE}','{DATE}'];
        $replace = [
              $this->trans->transId,
              $this->trans->transAu,
              $this->trans->transGatewayAu,
              $this->trans->transPrice,
              $this->controller->date(time()),
        ];
        $message = str_replace($find,$replace,self::MESSAGE);

        $send = $this->controller->sendEmail($to,$subject,$message);

        if(!$send) {
            Log::instance()->initialize()->write('email module','cannot send email !');
        }
    }
}