<?php
namespace app\controllers;
use app\components\Controller;
use framework\database\Database;
use framework\security\Csrf;
use framework\request\Request;
use framework\session\Session;
use app\models\FormModel;

class FormController extends Controller
{
    public function actionIndex($id = null, $tag = null)
    {
        $formId = (!is_null($id) ? intval($id) : $this->defaultForm);

        $model = new FormModel;
        
        if(Request::isPostRequest() and Csrf::validate()) {            
            if($model->validate()) {
                $fields = [
                        'saveFormId' => $formId,
                        'saveName' => ':name',
                        'saveEmail' => ':email',
                        'saveMobile' => ':mobile',
                        'saveContent' => ':content',
                        'saveIp' => ':ip',
                        'saveDate' => ':time',
                ];
                $params = [
                        ':name' => Request::getPost('name'),
                        ':email' => Request::getPost('email'),
                        ':mobile' => Request::getPost('mobile'),
                        ':content' => Request::getPost('content'),
                        ':ip' => Request::getRemoteAddr(),
                        ':time' => time(),
                ];
                $save = Database::queryBuilder()->insert('save', $fields, $params);
                unset($fields, $params);

                if($save) {
                       $au = $save . $this->randomCode(10,true);
                       $fields = [
                               'transFormId' => $formId,
                               'transSaveId' => $save,
                               'transPrice' => ':price',
                               'transModuleId' => ':gateway',
                               'transAu' => ':au',
                               'transIp' => ':ip',
                               'transDate' => ':time',
                               'transStatus' => 0
                       ];
                       $params = [
                               ':price' => Request::getPost('price'),
                               ':gateway' => Request::getPost('gateway'),
                               ':au' => $au,
                               ':ip' => Request::getRemoteAddr(),
                               ':time' => time(),
                       ];
                       $trans = Database::queryBuilder()->insert('trans',$fields,$params);
                }
                
                if(!$save or !isset($trans)) {
                    Session::instance()->setFlash('danger','مشکلی در اجرای عملیات پیش آمد');
                } else {
                    Request::redirect(\Framework::createUrl('request/factor',['au' => $au]));
                }
            }
        }
        
        $form = Database::queryBuilder()
            ->select('*')
            ->from('form')
            ->where('formId = :id')
            ->where('formStatus = 1','AND')
            ->getRow([':id' => $formId]);
        
        $modules = [];
        if($form) {
            $modules = Database::queryBuilder()
                ->select('*')
                ->from('module')
                ->where('moduleType = \'payment\'')
                ->where('moduleStatus = 1','AND')
                ->getAll();    
        }
        
        $this->render('form/index',
            [
                'model' => $model,
                'form' => $form,
                'modules' => $modules
            ]        
        );
    }
}