<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .=' - ورود';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
          <div class="main-box login">
                <div class="main-box-inner">
                      <hgroup><h3><span class="glyphicon glyphicon-log-in"></span>ورود به مدیریت</h3></hgroup>
                      <div class="login-img"><center><img src="<?php echo $this->getThemeUrl('img/avatar.png');?>" class="img-responsive"></center></div>
                      <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <?php echo Html::textField('userName',['class' => 'form-control','placeholder' => 'نام کاربری']);?>
                      </div>
                      <?php echo $model->getMessage('userName');?>
                      <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <?php echo Html::passwordField('password',['class' => 'form-control','placeholder' => 'کلمه عبور']);?>
                      </div>
                      <?php echo $model->getMessage('password');?>
                      <div class="form-group">
                            <?php echo Html::textField('captcha',['class' => 'form-control','placeholder' => 'کد امنیتی','style' => 'float:right;width:50%'],false);?>
                            <img src="<?php echo Framework::createUrl('captcha');?>?c=1" class="img-responsive" title="captcha" style="float:left;margin-top:3px;">
                      </div>
                      <?php echo $model->getMessage('captcha');?>
                      <div class="main-box-footer">
                            <div class="form-group">
                                  <button class="btn my-btn"><span class="glyphicon glyphicon-chevron-left"></span>ورود</button>
                            </div>
                      </div>

                      <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                            <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
                      <?php }?>
                </div>
          </div>
    </div>
</div>
</form>