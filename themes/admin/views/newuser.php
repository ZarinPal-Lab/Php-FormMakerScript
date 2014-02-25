<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ساخت مدیر جدید';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ساخت مدیر جدید</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="userName">نام کاربری<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('userName',['class' => 'form-control','id' => 'userName']);?>
               </div>
               <?php echo $model->getMessage('userName');?>

               <label for="email">ایمیل<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('email',['class' => 'form-control','id' => 'email']);?>
               </div>
               <?php echo $model->getMessage('email');?>

               <label for="password">کلمه عبور<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('password',['class' => 'form-control','id' => 'password']);?>
               </div>
               <?php echo $model->getMessage('password');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="ساخت">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>