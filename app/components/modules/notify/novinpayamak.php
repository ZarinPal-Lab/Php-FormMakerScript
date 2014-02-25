<?php
namespace app\components\modules\notify;
use app\components\modules\Notify;
use framework\log\Log;

class Novinpayamak extends Notify
{
       const WEB_SERVICE = 'http://www.novinpayamak.com/services/SMSBox/wsdl';

       const USERNAME = 974;

       const PASSWORD = 'test';

       const MESSAGE = 'تراکنش با شماره {ID} و کد پیگیری {AU} و مبلغ {PRICE} تومان در تاریخ {DATE} با موفقیت پرداخت شد';

       public function run()
       {
              $mobile = $this->controller->adminMobile;
              if(!is_numeric($mobile) or empty($mobile))
                     return false;

              \Framework::import(BASEPATH.'app/extensions/nusoap',true);

              $client = new \nusoap_client(self::WEB_SERVICE,'wsdl');

              $find = ['{ID}','{AU}','{PRICE}','{DATE}'];
              $replace = [
                     $this->trans->transId,
                     $this->trans->transAu,
                     $this->trans->transPrice,
                     $this->controller->date(time())
              ];

              $params = [
                     'Auth' => ['number' => self::USERNAME,'pass' => self::PASSWORD],
                     'Recipients' => ['string' => [$this->controller->adminMobile]],
                     'Message' => ['string' => [self::MESSAGE]],
                     'Flash' => false
              ];

              $result = $client->call('Send',[$params]);

              if(!is_numeric($result) and $result != 1000)
                     Log::instance()->initialize()->write('novinpayamak module',$result);
       }
}