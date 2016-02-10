<?php
namespace app\components\modules\payment;
use app\components\modules\Payment;
use framework\request\Request;

class Zarinpal extends Payment
{
	const WEB_SERVICE = 'https://de.zarinpal.com/pg/services/WebGate/wsdl'; // webservice

	const START_PAY = 'https://www.zarinpal.com/pg/StartPay/'; // start pay url

	const DESCRIPTION = 'payment'; // trans description

	const MERCHANT_ID = '28bc1b28-cc0b-11e5-8bc4-000c295eb8fc'; // merchant id
	
	public function gateway()
	{
		\Framework::import(BASEPATH.'app/extensions/nusoap',true);
              
		$client = new \nusoap_client(self::WEB_SERVICE,'wsdl');
              $client->soap_defencoding = 'UTF-8';
		$params = [
				'MerchantID' => self::MERCHANT_ID,
				'Amount' => $this->trans->transPrice,
				'Description' => self::DESCRIPTION,
				'CallbackURL' => $this->callbackUrl
		];
		$result = $client->call('PaymentRequest',[$params]);

		// check error
		if($error = $client->getError())
			$this->setFlash('danger',$error);
		else if(isset($result['Status'],$result['Authority']) and $result['Status'] == 100) {
			// success request
			$this->updateGatewayAu($result['Authority']);
			Request::redirect(self::START_PAY.$result['Authority']);
		} elseif(isset($result['Status']))
			$this->errors($result['Status']);
		else
			$this->setFlash('danger','خطا در اتصال به درگاه زرین پال');
	}

	public function callback()
	{
		if(Request::getQuery('Authority') != $this->trans->transGatewayAu
              or !Request::isQuery('Status')) {
			$this->setFlash('danger','ورودی نامعتبر است');
			return false;
		}
             if(Request::getQuery('Status') != "OK") {
		$this->setFlash('danger','پرداخت انجام نشد');
		return false;
	}
		
		\Framework::import(BASEPATH.'app/extensions/nusoap',true);

		$client = new \nusoap_client(self::WEB_SERVICE,'wsdl');
              $client->soap_defencoding = 'UTF-8';
		$params = [
				'MerchantID' => self::MERCHANT_ID,
				'Authority' => Request::getQuery('Authority'),
				'Amount' => $this->trans->transPrice
		];
		$result = $client->call('PaymentVerification',[$params]);
		//print_r($result);
		// check error
		if($error = $client->getError())
			$this->setFlash('danger',$error);
		else if(isset($result['Status']) and $result['Status'] == 100) {
			// success payment
			$this->updateTrans($result['RefID']);
			$this->setFlash('success','پرداخت با موفقیت انجام شد');
			return true;
		} else if(isset($result['Status']))
			$this->errors($result['Status']);
		else
			$this->setFlash('danger','خطا در اتصال به درگاه زرین پال');

		return false;
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
