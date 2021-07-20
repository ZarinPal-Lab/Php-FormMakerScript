<?php
namespace app\components\modules\payment;
use framework\helpers\Html;
use framework\database\Database;
use app\components\modules\Payment;
use framework\request\Request;

class Zarinpal extends Payment
{
	const WEB_SERVICE = 'https://de.zarinpal.com/pg/services/WebGate/wsdl'; // webservice

	const START_PAY = 'https://www.zarinpal.com/pg/StartPay/'; // start pay url

	const DESCRIPTION = 'payment'; // trans description

	const MERCHANT_ID = ''; // merchant id
	
	public function gateway()
	{
              
	        $formName = Database::queryBuilder()
	            ->select('formName')
	            ->from('form')
	            ->where('formId = :id')
	            ->where('formStatus = 1','AND')
	            ->getRow([':id' => $this->trans->transFormId]); 
	        $Description=Html::escape($formName->formName);     

 	   $data = array("merchant_id" => self::MERCHANT_ID,
   	 "amount" => $this->trans->transPrice * 10,
   	 "callback_url" => $this->callbackUrl,
   	 "description" => $Description,//self::DESCRIPTION,
  	  );
	$jsonData = json_encode($data);
	$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
	curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   	 'Content-Type: application/json',
    	'Content-Length: ' . strlen($jsonData)
	));

$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true, JSON_PRETTY_PRINT);
curl_close($ch);



if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if (empty($result['errors'])) {
        if ($result['data']['code'] == 100) {
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
        }
    } else {
         echo'Error Code: ' . $result['errors']['code'];
         echo'message: ' .  $result['errors']['message'];

    }
	}
}

	public function callback()
	{

             if(Request::getQuery('Status') != "OK") {
		$this->setFlash('danger','پرداخت انجام نشد');
		return false;
	}

        $data = array("merchant_id" => self::MERCHANT_ID, "authority" => Request::getQuery('Authority'), "amount" => $this->trans->transPrice * 10);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);

        if (empty($result['data'])) {
            $this->setFlash('danger','خطا در انجام پرداخت');
        } else {
            if ($result['data']['code'] == 100 || $result['data']['code'] == 101) {
                $this->updateTrans($result['data']['ref_id']);
			   $this->setFlash('success','پرداخت با موفقیت انجام شد');
			   return true;
            } else {
                echo'code: ' . $result['errors']['code'];
                echo'message: ' .  $result['errors']['message'];
            }
        }
}

	private function errors($status)
	{
		switch($status) {
			case '-1':
				$this->setFlash('danger','اطلاعات ارسال شده صحیح نیست');
				break;
			case '-2':
				$this->setFlash('danger','آی پی و یا کد مرچنت صحیح نیست');
				break;
			case '-3':
				$this->setFlash('danger','مبلغ باید بیشتر از 100 تومان باشد');
				break;
			case '-4':
				$this->setFlash('danger','سطح تایید پذیرنده پایینتر از نقره ای است');
				break;
			case '-11':
				$this->setFlash('danger','درخواست مورد نظر یافت نشد');
				break;
			case '-21':
				$this->setFlash('danger','هیچ نوع عملیات مالی برای این تراکنش یافت نشد');
				break;
			case '-22':
				$this->setFlash('danger','تراکنش ناموفق است');
				break;
			case '-33':
				$this->setFlash('danger','رقم تراکنش با رقم پرداخت شده مطابقت ندارد');
				break;
			case '-54':
				$this->setFlash('danger','درخواست مورد نظر آرشیو شده است');
				break;
			case '101':
				$this->setFlash('danger','عملیات پرداخت با موفقیت انجام شده است اما قبلا عملیات verify بر روی این تراکنش انجام شده است');
				break;
			default:
				$this->setFlash('danger',"خطای ناشناخته {$status}");
		}
	}
}
