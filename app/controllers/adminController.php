<?php
namespace app\controllers;
use app\components\AController;
use app\components\Admin;
use app\models\LoginModel;
use app\models\admin\UserModel;
use app\models\admin\FormModel;
use app\models\admin\DescModel;
use app\models\admin\ModuleModel;
use app\models\admin\SearchModel;
use app\models\admin\OptionModel;
use framework\request\Request;
use framework\security\Csrf;
use framework\database\Database;
use framework\session\Session;
use framework\pagination\Pagination;

class AdminController extends AController
{
	public function actionIndex()
	{
		$admin = new Admin();
		
		if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

		$contact = Database::queryBuilder()
					->select('COUNT(*) as count')
					->from('contact')
					->where('contactRead = 0')
					->getRow();
					
		$trans = Database::queryBuilder()
				->select('COUNT(*) as count')
				->from('trans')
				->where('transDate >= :date')
				->where('transStatus = 1','AND')
				->getRow([':date' => strtotime('-1 day')]);
				
		$amount = Database::queryBuilder()
					->select('SUM(transPrice) as amount')
					->from('trans')
					->where('transDate >= :date')
					->where('transStatus = 1','AND')
					->getRow([':date' => strtotime('-1 day')]);
					
		$allTrans = Database::queryBuilder()
					->select('COUNT(*) as count')
					->from('trans')
					->getRow();
		
		$successTrans = Database::queryBuilder()
						->select('COUNT(*) as count')
						->from('trans')
						->where('transStatus = 1')
						->getRow();
						
		$allTransAmount = Database::queryBuilder()
							->select('SUM(transPrice) as amount')
							->from('trans')
							->getRow();
							
		$successTransAmount = Database::queryBuilder()
								->select('SUM(transPrice) as amount')
								->from('trans')
								->where('transStatus = 1')
								->getRow();
			
		$this->render('index',
				[
					'contact' => $contact,
					'trans' => $trans,
					'amount' => $amount,
					'allTrans' => $allTrans,
					'successTrans' => $successTrans,
					'allTransAmount' => $allTransAmount,
					'successTransAmount' => $successTransAmount,
 				]
		);
	}

	public function actionUser()
	{
	       $admin = new Admin();

		if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('user','userId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

	       $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('user')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);
	       $users = Database::queryBuilder()
                            ->select('*')
                            ->from('user')
                            ->orderBy('userId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

		$this->render('user',
                     [
                            'users' => $users,
                            'pagination' => $pagination,
                     ]
              );
	}

       public function actionNewuser()
       {
              $admin = new Admin();

		if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new UserModel;

              if(Request::isPostRequest() and Csrf::validate()) {
                     if($model->validate()) {
                            $userIsReady = Database::queryBuilder()
                                                 ->select('*')
                                                 ->from('user')
                                                 ->where('userName = :name')
                                                 ->getRow([':name' => Request::getPost('userName')]);
                            if(!$userIsReady) {
                                   $fields = [
                                          'userName' => ':userName',
                                          'userPassword' => ':password',
                                          'userEmail' => ':email',
                                   ];
                                   $password = $this->createPassword(Request::getPost('password'));
                                   $params = [
                                          ':userName' => Request::getPost('userName'),
                                          ':password' => $password,
                                          ':email' => Request::getPost('email'),
                                   ];
                                   Database::queryBuilder()->insert('user',$fields,$params);
                                   Session::instance()->setFlash('success','مدیر جدید با موفقیت ساخته شد');
                                   $this->refresh();
                            } else
                                   Session::instance()->setFlash('danger','نام کاربری وارد شده قبلا ثبت شده است');
                     }
              }

              $this->render('newuser',
                     [
                            'model' => $model,
                     ]
              );
       }

       public function actionEdituser($id = 0)
       {
              $admin = new Admin();

		if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new UserModel;

              if(Request::isPostRequest() and Csrf::validate()) {
                     if($model->validate()) {
                            $fields['userEmail'] = ':email';
                            $params['email'] = Request::getPost('email');
                            if(Request::getPost('password') !== 'c') {
                                   $fields['userPassword'] = ':password';
                                   $params[':password'] = $this->createPassword(Request::getPost('password'));
                            }
                            $params[':id'] = intval($id);
                            Database::queryBuilder()->update('user',$fields,'userId = :id',$params);
                            Session::instance()->setFlash('success','ویرایش با موفقیت انجام شد');
                     }
              }

              $user = Database::queryBuilder()
                            ->select('*')
                            ->from('user')
                            ->where('userId = :id')
                            ->getRow([':id' => intval($id)]);

              $this->render('edituser',
                     [
                            'model' => $model,
                            'user' => $user,
                     ]
              );
       }

       public function actionForm()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('form','formId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('form')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $forms = Database::queryBuilder()
                            ->select('*')
                            ->from('form')
                            ->orderBy('formId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('form',
                     [
                            'forms' => $forms,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionNewform()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new FormModel;

              if(Request::isPostRequest() and Csrf::validate()) {
                     if($model->validate()) {
                            $fields = [
                                   'formName' => ':name',
                                   'formDescription' => ':desc',
                                   'formTag' => ':tag',
                                   'formContent' => ':content',
                                   'formPriceType' => ':type',
                                   'formPriceValue' => ':value',
                                   'formStatus' => ':status',
                            ];

                            $params = [
                                   ':name' => Request::getPost('formName'),
                                   ':desc' => Request::getPost('formDescription'),
                                   ':tag' => Request::getPost('formTag'),
                                   ':content' => Request::getPost('formContent'),
                                   ':type' => Request::getPost('formPriceType'),
                                   ':value' => Request::getPost('formPriceValue'),
                                   ':status' => Request::getPost('formStatus'),
                            ];

                            Database::queryBuilder()->insert('form',$fields,$params);
                            Session::instance()->setFlash('success','فرم جدید با موفقیت ساخته شد');
                            $this->refresh();
                     }
              }

              $this->render('newform',
                     [
                            'model' => $model,
                     ]
              );
       }

       public function actionEditform($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new FormModel;

              if(Request::isPostRequest() and Csrf::validate()) {
                     if($model->validate()) {
                            $fields = [
                                   'formName' => ':name',
                                   'formDescription' => ':desc',
                                   'formTag' => ':tag',
                                   'formContent' => ':content',
                                   'formPriceType' => ':type',
                                   'formPriceValue' => ':value',
                                   'formStatus' => ':status',
                            ];

                            $params = [
                                   ':name' => Request::getPost('formName'),
                                   ':desc' => Request::getPost('formDescription'),
                                   ':tag' => Request::getPost('formTag'),
                                   ':content' => Request::getPost('formContent'),
                                   ':type' => Request::getPost('formPriceType'),
                                   ':value' => Request::getPost('formPriceValue'),
                                   ':status' => Request::getPost('formStatus'),
                                   ':id' => $id,
                            ];

                            Database::queryBuilder()->update('form',$fields,'formId = :id',$params);
                            Session::instance()->setFlash('success','ویرایش با موفقیت انجام شد');
                            $this->refresh();
                     }
              }

              $form = Database::queryBuilder()
                            ->select('*')
                            ->from('form')
                            ->where('formId = :id')
                            ->getRow([':id' => $id]);

              $this->render('editform',
                     [
                            'model' => $model,
                            'form' => $form,
                     ]
              );
       }

       public function actionTrans()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('trans','transId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('trans')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $trans = Database::queryBuilder()
                            ->select('*')
                            ->from('trans')
                            ->orderBy('transId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('trans',
                     [
                            'trans' => $trans,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionShowtrans($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $trans = Database::queryBuilder()
                            ->select('*')
                            ->from('trans')
                            ->join('module ON moduleId = trans.transModuleId','LEFT JOIN')
                            ->where('transId = :id')
                            ->getRow([':id' => $id]);

              $this->render('showtrans',
                     [
                            'trans' => $trans,
                     ]
              );
       }

       public function actionItem()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('save','saveId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('save')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $save = Database::queryBuilder()
                            ->select('*')
                            ->from('save')
                            ->orderBy('saveId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('item',
                     [
                            'save' => $save,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionShowitem($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $save = Database::queryBuilder()
                            ->select('*')
                            ->from('save')
                            ->where('saveId = :id')
                            ->getRow([':id' => $id]);

              $this->render('showitem',
                     [
                            'save' => $save,
                     ]
              );
       }

       public function actionDesc()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('after_payment','afterPaymentId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('after_payment')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $desc = Database::queryBuilder()
                            ->select('*')
                            ->from('after_payment')
                            ->orderBy('afterPaymentId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('desc',
                     [
                            'desc' => $desc,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionNewdesc()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new DescModel;

              $forms = Database::queryBuilder()
                            ->select('*')
                            ->from('form')
                            ->orderBy('formId DESC')
                            ->getAll();

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     $isReady = Database::queryBuilder()
                                   ->select('*')
                                   ->from('after_payment')
                                   ->where('afterPaymentFormId = :fid')
                                   ->getRow([':fid' => Request::getPost('formId')]);

                     if(!$isReady) {
                            $fields = [
                                   'afterPaymentFormId' => ':fid',
                                   'afterPaymentContent' => ':content',
                            ];
                            $params = [
                                   ':fid' => Request::getPost('formId'),
                                   ':content' => Request::getPost('formContent'),
                            ];
                            Database::queryBuilder()->insert('after_payment',$fields,$params);
                            Session::instance()->setFlash('success','توضیحات برای فرم مورد نظر با موفقیت افزوده شد');
                            $this->refresh();
                     } else
                            Session::instance()->setFlash('danger','در حال حاظر توضیحات برای این فرم وجود دارد');
              }

              $this->render('newdesc',
                     [
                            'forms' => $forms,
                            'model' => $model,
                     ]
              );
       }

       public function actionEditdesc($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new DescModel;

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     $fields = [
                            'afterPaymentContent' => ':content',
                     ];
                     $params = [
                            ':content' => Request::getPost('formContent'),
                            ':id' => $id,
                     ];
                     Database::queryBuilder()->update('after_payment',$fields,'afterPaymentId = :id',$params);
                     Session::instance()->setFlash('success','ویرایش با موفقیت انجام شد');
                     $this->refresh();
              }

              $desc = Database::queryBuilder()
                            ->select('*')
                            ->from('after_payment')
                            ->where('afterPaymentId = :id')
                            ->getRow([':id' => $id]);
              $forms = [];
              if($desc) {
              $forms = Database::queryBuilder()
                            ->select('*')
                            ->from('form')
                            ->orderBy('formId DESC')
                            ->getAll();
              }

              $this->render('editdesc',
                     [
                            'desc' => $desc,
                            'forms' => $forms,
                            'model' => $model,
                     ]
              );
       }

       public function actionModule()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('module','moduleId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('module')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $modules = Database::queryBuilder()
                            ->select('*')
                            ->from('module')
                            ->orderBy('moduleId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('module',
                     [
                            'modules' => $modules,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionNewmodule()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new ModuleModel;

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     $fields = [
                            'moduleName' => ':name',
                            'moduleFileName' => ':filename',
                            'moduleType' => ':type',
                            'moduleStatus' => ':status',
                     ];
                     $params = [
                            ':name' => Request::getPost('moduleName'),
                            ':filename' => Request::getPost('moduleFileName'),
                            ':type' => Request::getPost('moduleType'),
                            ':status' => Request::getPost('moduleStatus'),
                     ];
                     Database::queryBuilder()->insert('module',$fields,$params);
                     Session::instance()->setFlash('success','ماژول جدید با موفقیت ساخته شد');
                     $this->refresh();
              }

              $this->render('newmodule',
                     [
                            'model' => $model,
                     ]
              );
       }

       public function actionEditmodule($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new ModuleModel;

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     $fields = [
                            'moduleName' => ':name',
                            'moduleFileName' => ':filename',
                            'moduleType' => ':type',
                            'moduleStatus' => ':status',
                     ];
                     $params = [
                            ':name' => Request::getPost('moduleName'),
                            ':filename' => Request::getPost('moduleFileName'),
                            ':type' => Request::getPost('moduleType'),
                            ':status' => Request::getPost('moduleStatus'),
                            ':id' => $id,
                     ];
                     Database::queryBuilder()->update('module',$fields,'moduleId = :id',$params);
                     Session::instance()->setFlash('success','ویرایش با موفقیت انجام شد');
                     $this->refresh();
              }

              $module = Database::queryBuilder()
                            ->select('*')
                            ->from('module')
                            ->where('moduleId = :id')
                            ->getRow([':id' => $id]);

              $this->render('editmodule',
                     [
                            'module' => $module,
                            'model' => $model,
                     ]
              );
       }

       public function actionContact()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              if(Request::getPost('pick') and Csrf::validate()) {
                     foreach(Request::getPost('pick') as $id)
                            Database::queryBuilder()->delete('contact','contactId = :id',[':id' => $id]);
                     Session::instance()->setFlash('success','حذف با موفقیت انجام شد');
              }

              $pagination = new Pagination();
              $rows = Database::queryBuilder()
                            ->select('COUNT(*) as count')
                            ->from('contact')
                            ->getRow();
              $config = [
                     'fullRows' => $rows->count,
                     'itemLimit' => $this->perPage,
              ];
              $pagination->initialize($config);

              $contacts = Database::queryBuilder()
                            ->select('*')
                            ->from('contact')
                            ->orderBy('contactId DESC')
                            ->limit($pagination->applyLimit())
                            ->offset($pagination->applyOffset())
                            ->getAll();

              $this->render('contact',
                     [
                            'contacts' => $contacts,
                            'pagination' => $pagination,
                     ]
              );
       }

       public function actionShowcontact($id = 0)
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              Database::queryBuilder()
                     ->update('contact',['contactRead' => 1],'contactId = :id',[':id' => $id]);

              $contact = Database::queryBuilder()
                            ->select('*')
                            ->from('contact')
                            ->where('contactId = :id')
                            ->getRow([':id' => $id]);

              $this->render('showcontact',
                     [
                            'contact' => $contact,
                     ]
              );
       }

       public function actionSearch()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new SearchModel;

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     $query = Database::queryBuilder()->select('*')->from('trans');
                     $params = [];

                     if(Request::getPost('saveName')) {
                            $query->join('save ON saveName = :name AND transSaveId = save.saveId','INNER JOIN');
                            $params[':name'] = Request::getPost('saveName');
                     }
                     if(Request::getPost('saveEmail')) {
                            $query->join('save ON saveEmail = :email AND transSaveId = save.saveId','INNER JOIN');
                            $params[':email'] = Request::getPost('saveEmail');
                     }
                     if(Request::getPost('transAu')) {
                            $query->where('trans.transAu = :au');
                            $params[':au'] = Request::getPost('transAu');
                            $where = true;
                     }
                     if(Request::getPost('transGatewayAu')) {
                            if(isset($where))
                                   $query->where('trans.transGatewayAu = :gau','AND');
                            else
                                   $query->where('trans.transGatewayAu = :gau');
                            $params[':gau'] = Request::getPost('transGatewayAu');
                            $where = true;
                     }
                     if(Request::getPost('transStatus') != 'no') {
                            if(isset($where))
                                   $query->where('trans.transStatus = :status','AND');
                            else
                                   $query->where('trans.transStatus = :status');
                            $params[':status'] = Request::getPost('transStatus');
                     }

                     $query->orderBy('trans.transId DESC');
                     $query->limit(Request::getPost('limit'));
                     $trans = $query->getAll($params);

                     if(!$trans)
                            Session::instance()->setFlash('danger','چیزی یافت نشد');
              }

              $this->render('search',
                     [
                            'trans' => (isset($trans) ? $trans : false),
                            'model' => $model,
                     ]
              );
       }

       public function actionOption()
       {
              $admin = new Admin();

              if(!$admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/login'));

              $model = new OptionModel;

              if(Request::isPostRequest() and Csrf::validate() and $model->validate()) {
                     if(Request::getPost('title') != $this->title)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'title\'',[':value' => Request::getPost('title')]);

                     if(Request::getPost('theme') != $this->siteTheme)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'theme\'',[':value' => Request::getPost('theme')]);

                     if(Request::getPost('defaultForm') != $this->defaultForm)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'defaultForm\'',[':value' => Request::getPost('defaultForm')]);

                     if(Request::getPost('perPage') != $this->perPage)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'perPage\'',[':value' => Request::getPost('perPage')]);

                     if(Request::getPost('smtpHost') != $this->smtpHost)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'smtpHost\'',[':value' => Request::getPost('smtpHost')]);

                     if(Request::getPost('smtpPort') != $this->smtpPort)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'smtpPort\'',[':value' => Request::getPost('smtpPort')]);

                     if(Request::getPost('smtpSecure') != $this->smtpSecure)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'smtpSecure\'',[':value' => Request::getPost('smtpSecure')]);

                     if(Request::getPost('smtpUserName') != $this->smtpUserName)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'smtpUserName\'',[':value' => Request::getPost('smtpUserName')]);

                     if(Request::getPost('smtpPassword') != $this->smtpPassword)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'smtpPassword\'',[':value' => Request::getPost('smtpPassword')]);

                     if(Request::getPost('adminMail') != $this->adminMail)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'adminMail\'',[':value' => Request::getPost('adminMail')]);

                     if(Request::getPost('adminMobile') != $this->adminMobile)
                            Database::queryBuilder()->update('option',['optionValue' => ':value'],'optionName = \'adminMobile\'',[':value' => Request::getPost('adminMobile')]);
                     
                     Session::instance()->setFlash('success','ویرایش با موفقیت انجام شد');
                     $this->refresh();
              }

              $forms = Database::queryBuilder()
                            ->select('*')
                            ->from('form')
                            ->orderBy('formId DESC')
                            ->getAll();

              $this->render('option',
                     [
                            'model' => $model,
                            'forms' => $forms,
                     ]
              );
       }

	public function actionLogin()
	{
		$admin = new Admin();

		if($admin->getIsLogged())
			Request::redirect(\Framework::createUrl('admin/index'));

		$model = new LoginModel;

		if(Request::isPostRequest() and Csrf::validate() ) {
			if($model->validate()) {
				$password = $this->createPassword(Request::getPost('password'));

				if($admin->login(Request::getPost('userName'),$password))
					Request::redirect(\Framework::createUrl('admin/index'));
				else
					Session::instance()->setFlash('danger','نام کاربری و یا کلمه عبور وارد شده صحیح نیست');
			}
		}
		
		$this->render('login',['model' => $model]);
	}
	
	public function actionLogout()
	{
		$admin = new Admin();
		if($admin->getIsLogged())
			$admin->logout();
		Request::redirect(\Framework::createUrl('admin/login'));
	}
}