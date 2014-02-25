<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ویرایش مدیر';
if($user) {
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش مدیر <?php echo Html::escape($user->userName);?></h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <div class="form-group">
                     <?php echo Html::hiddenField('userName',['class' => 'form-control','id' => 'userName','value' => $user->userName],false);?>
               </div>
               <?php echo $model->getMessage('userName');?>

               <label for="email">ایمیل<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('email',['class' => 'form-control','id' => 'email','value' => $user->userEmail],false);?>
               </div>
               <?php echo $model->getMessage('email');?>

               <div class="alert alert-info">در صورتی که نمیخواهید کلمه عبور را تغییر دهید فیلد زیر را دست نزنید</div>

               <label for="password">کلمه عبور<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('password',['class' => 'form-control','id' => 'password','value' => 'c'],false);?>
               </div>
               <?php echo $model->getMessage('password');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="ویرایش">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>
<?php } else {?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش مدیر</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>