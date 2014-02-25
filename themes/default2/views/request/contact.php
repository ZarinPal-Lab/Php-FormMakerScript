<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - تماس با ما';
?>
<section>
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3>تماس با ما</h3></hgroup>
                            <p>لطفا اطلاعات دقیق خود را وارد کنید</p>
                            <form method="POST" name="myForm">
                            <div style="display:none"><?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?></div>
                                   <table class="table">
                                          <tbody>
                                                   <tr>
                                                         <td width="120"><label for="name">نام و نام خانوادگی<span>*</span></label></td><td><?php echo Html::textField('name', ['id' => 'name', 'class' => 'form-control']);?><?php echo $model->getMessage('name');?></td>
                                                   </tr>
                                                   <tr>
                                                         <td width="120"><label for="email">ایمیل<span>*</span></label></td><td><?php echo Html::textField('email', ['id' => 'email', 'class' => 'form-control']);?><?php echo $model->getMessage('email');?></td>
                                                   </tr>
                                                   <tr>
                                                         <td width="120"><label for="subject">موضوع<span>*</span></label></td><td><?php echo Html::textField('subject', ['id' => 'subject', 'class' => 'form-control']);?><?php echo $model->getMessage('subject');?></td>
                                                   </tr>
                                                   <tr>
                                                        <td width="120"><label for="content">توضیحات<span>*</span></label></td><td><?php echo Html::textArea('content', '', ['id' => 'content', 'class' => 'form-control','rows' => 5]);?><?php echo $model->getMessage('content');?></td>
                                                   </tr>
                                                   <tr>
                                                        <td width="120"><label for="captcha">کد امنیتی<span>*</span></label></td><td><?php echo Html::textField('captcha',  ['id' => 'captcha', 'class' => 'form-control','style' => 'float:right;width:55%'],false);?><img style="float:left;" class="img-responsive" src="<?php echo Framework::createUrl('captcha');?>?c=1"><?php echo $model->getMessage('captcha');?></td>
                                                   </tr>
                                                   <tr>
                                                        <td width="140"><button type="submit" class="btn myBtn"><span class="glyphicon glyphicon-chevron-left"></span> ارسال درخواست</button></td>
                                                   </tr>
                                          </tbody>
                                   </table>
                            </form>
                            <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value) {?>
                                   <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
                            <?php }?>
                     </div>
              </div>
       </div>
</section>