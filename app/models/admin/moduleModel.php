<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class ModuleModel extends Model
{
       public function rules()
       {
              return [
                     'required' => [
                            'moduleName' => [
                                   'itemValue' => Request::getPost('moduleName'),
                                   'itemMessage' => 'نام ماژول را وارد کنید',
                            ],
                            'moduleFileName' => [
                                   'itemValue' => Request::getPost('moduleFileName'),
                                   'itemMessage' => 'نام فایل ماژول را وارد کنید',
                            ],
                            'moduleType' => [
                                   'itemValue' => Request::getPost('moduleType'),
                                   'itemMessage' => 'نوع ماژول را انتخاب کنید',
                            ],
                            'moduleStatus' => [
                                   'itemValue' => Request::getPost('moduleStatus'),
                                   'itemMessage' => 'وضعیت را انتخاب کنید',
                            ],
                     ],
                     'numerical' => [
                            'moduleStatus' => [
                                   'itemValue' => Request::getPost('moduleStatus'),
                                   'itemMessage' => 'وضعیت باید عددی باشد',
                            ],
                     ],

              ];
       }
}