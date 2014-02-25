<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class SearchModel extends Model
{
       public function rules()
       {
              return [
                     'email' => [
                            'saveEmail' => [
                                   'itemValue' => Request::getPost('saveEmail'),
                                   'itemMessage' => 'ایمیل وارد شده صحیح نیست',
                            ],
                     ],
                     'numerical' => [
                            'limit' => [
                                   'itemValue' => Request::getPost('limit'),
                                   'itemMessage' => 'تعداد نمایش باید عددی باشد',
                            ],
                     ],
              ];
       }
}