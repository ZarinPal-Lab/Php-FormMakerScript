<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ویرایش ماژول';
if($module){
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش ماژول</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="moduleName">نام ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('moduleName',['class' => 'form-control','id' => 'moduleName','value' => $module->moduleName]);?>
               </div>
               <?php echo $model->getMessage('moduleName');?>

               <label for="moduleFileName">نام فایل ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('moduleFileName',['class' => 'form-control','id' => 'moduleFileName','value' => $module->moduleFileName]);?>
               </div>
               <?php echo $model->getMessage('moduleFileName');?>

               <label for="moduleType">نوع ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('moduleType',['payment' => 'پرداخت','notify' => 'اطلاع رسانی'],['class' => 'form-control','id' => 'moduleType'],$module->moduleType);?>
               </div>
               <?php echo $model->getMessage('moduleType');?>

               <label for="moduleStatus">وضعیت ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('moduleStatus',[1 => 'فعال',0 => 'غیر فعال'],['class' => 'form-control','id' => 'moduleStatus'],(int)$module->moduleStatus);?>
               </div>
               <?php echo $model->getMessage('moduleStatus');?>

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
               <hgroup><h3>ویرایش ماژول</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>