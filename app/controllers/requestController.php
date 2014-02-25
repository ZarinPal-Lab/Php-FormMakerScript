<?php
namespace app\controllers;
use app\components\Controller;
use framework\database\Database;
use framework\session\Session;
use framework\request\Request;
use framework\security\Csrf;
use app\models\ContactModel;

class RequestController extends Controller
{
    public $defaultAction = 'factor';
    
    public function actionFactor($au = null)
    {        
        $factor = Database::queryBuilder()
            ->select('*')
            ->from('save')
            ->join('trans ON transSaveId = save.saveId','INNER JOIN')
            ->join('module ON moduleId = trans.transModuleId AND moduleStatus = 1','LEFT JOIN')
            ->where('trans.transAu = :au')
            ->getRow([':au' => $au]);

        $this->render('request/factor',
            [
                'factor' => $factor
            ]
        );
    }
    
    public function actionGateway($au = null)
    {
        if($trans = $this->getTrans($au)) {
            $className = 'app\components\modules\payment\\'.ucfirst($trans->moduleFileName);
            $class = new $className($trans);
            $class->gateway();
        }
        
        $this->render('request/gateway');
    }

    public function actionCallback($au = null)
    {
       ignore_user_abort(true);
       if($trans = $this->getTrans($au)) {
              $className = 'app\components\modules\payment\\'.ucfirst($trans->moduleFileName);
              $class = new $className($trans);

              if($class->callback()) {
                     $trans = Database::queryBuilder()
                            ->select('*')
                            ->from('trans')
                            ->join('after_payment ON afterPaymentFormId = trans.transFormId','LEFT JOIN')
                            ->join('save ON saveId = trans.transSaveId','INNER JOIN')
                            ->where('trans.transAu = :au')
                            ->where('trans.transStatus = 1','AND')
                            ->getRow([':au' => $au]);
              } else $trans = false;
       }

       $this->render('request/callback',
              [
                     'trans' => $trans
              ]
       );
       if($trans) $this->runNotifyModules($trans);
    }

    private function getTrans($au)
    {
        $trans = Database::queryBuilder()
            ->select('*')
            ->from('trans')
            ->join('module ON moduleId = trans.transModuleId AND moduleStatus = 1','LEFT JOIN')
            ->join('form ON formId = trans.transFormId AND formStatus = 1','LEFT JOIN')
	     ->join('save ON saveId = trans.transSaveId','INNER JOIN')
            ->where('trans.transAu = :au')
            ->getRow([':au' => $au]);

        if(!$trans)
            Session::instance()->setFlash('danger','چیزی یافت نشد');
        else if($trans->transStatus == 1)
            Session::instance()->setFlash('success','تراکنش مورد نظر قبلا پرداخت شده است');
        else if($trans->moduleId == null)
            Session::instance()->setFlash('danger','درگاه پرداخت انتخابی وجود ندارد و یا حذف شده است');
        else if($trans->formId == null)
            Session::instance()->setFlash('danger','فرم این تراکنش وجود ندارد و یا حذف شده است');
        else
            return $trans;

        return false;
    }
    
    private function runNotifyModules($trans)
    {
        if(!ini_get('safe_mode')) {
            set_time_limit(0);
        }

        $modules = Database::queryBuilder()
            ->select('*')
            ->from('module')
            ->where('moduleType = \'notify\'')
            ->where('moduleStatus = 1','AND')
            ->getAll(); 
        
        foreach($modules as $module) {
            $className = 'app\components\modules\notify\\'.ucfirst($module->moduleFileName);
            $class = new $className($trans);
            $class->run();
        }
    }
	
	public function actionContact()
	{
		$model = new ContactModel;
		
		if(Request::isPostRequest() and Csrf::validate()) {
			if($model->validate()) {
				$fields = [
						'contactName' => ':name',
						'contactEmail' => ':email',
						'contactSubject' => ':subject',
						'contactContent' => ':content',
						'contactIp' => ':ip',
						'contactDate' => ':date',
						'contactRead' => 0
				];
				$params = [
						':name' => Request::getPost('name'),
						':email' => Request::getPost('email'),
						':subject' => Request::getPost('subject'),
						':content' => Request::getPost('content'),
						':ip' => Request::getRemoteAddr(),
						':date' => time(),
				];
				$save = Database::queryBuilder()->insert('contact',$fields,$params);
				
				if($save) {
					Session::instance()->setFlash('success','درخواست شما با موفقیت ارسال شد');
					$this->refresh();
				}
				else
					Session::instance()->setFlash('danger','مشکلی در اجرای عملیات پیش آمد');
			}
		}
		
		$this->render('request/contact',
			[
				'model' => $model,
			]
		);
	}
}