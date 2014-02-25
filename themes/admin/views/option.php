<?php
use framework\helpers\Html;
use framework\security\Csrf;
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش تنظیمات</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="title">عنوان سایت<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('title',['class' => 'form-control','id' => 'title','value' => $this->title]);?>
               </div>
               <?php echo $model->getMessage('title');?>

               <label for="theme">قالب سایت<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('theme',['class' => 'form-control','id' => 'theme','value' => $this->siteTheme]);?>
               </div>
               <?php echo $model->getMessage('theme');?>

               <label for="defaultForm">فرم پیشفرض<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('defaultForm',Html::convertObjectToDropDownList($forms,'formId','formName'),['class' => 'form-control','id' => 'defaultForm'],(int)$this->defaultForm);?>
               </div>
               <?php echo $model->getMessage('defaultForm');?>

               <label for="perPage">تعداد آیتم ها در صفحات<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('perPage',['class' => 'form-control','id' => 'perPage','value' => $this->perPage]);?>
               </div>
               <?php echo $model->getMessage('perPage');?>

               <label for="smtpHost">هاست SMTP<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('smtpHost',['class' => 'form-control','id' => 'smtpHost','value' => $this->smtpHost]);?>
               </div>
               <?php echo $model->getMessage('smtpHost');?>

               <label for="smtpPort"> پورت SMTP<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('smtpPort',['class' => 'form-control','id' => 'smtpPort','value' => $this->smtpPort]);?>
               </div>
               <?php echo $model->getMessage('smtpPort');?>

               <label for="smtpSecure">اتصال SMTP<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('smtpSecure',['class' => 'form-control','id' => 'smtpSecure','value' => $this->smtpSecure]);?>
               </div>
               <?php echo $model->getMessage('smtpSecure');?>


               <label for="smtpUserName">نام کاربری SMTP<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('smtpUserName',['class' => 'form-control','id' => 'smtpUserName','value' => $this->smtpUserName]);?>
               </div>
               <?php echo $model->getMessage('smtpUserName');?>

               <label for="smtpPassword"> کلمه عبور SMTP<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('smtpPassword',['class' => 'form-control','id' => 'smtpPassword','value' => $this->smtpPassword]);?>
               </div>
               <?php echo $model->getMessage('smtpPassword');?>

               <label for="adminMail">ایمیل مدیر<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('adminMail',['class' => 'form-control','id' => 'adminMail','value' => $this->adminMail]);?>
               </div>
               <?php echo $model->getMessage('adminMail');?>

                <label for="adminMobile">موبایل مدیر<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('adminMobile',['class' => 'form-control','id' => 'adminMobile','value' => $this->adminMobile]);?>
               </div>
               <?php echo $model->getMessage('adminMobile');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="ویرایش">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>