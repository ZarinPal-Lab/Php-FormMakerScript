<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ماژول جدید';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ماژول جدید</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="moduleName">نام ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('moduleName',['class' => 'form-control','id' => 'moduleName']);?>
               </div>
               <?php echo $model->getMessage('moduleName');?>

               <label for="moduleFileName">نام فایل ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('moduleFileName',['class' => 'form-control','id' => 'moduleFileName']);?>
               </div>
               <?php echo $model->getMessage('moduleFileName');?>

               <label for="moduleType">نوع ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('moduleType',['payment' => 'پرداخت','notify' => 'اطلاع رسانی'],['class' => 'form-control','id' => 'moduleType']);?>
               </div>
               <?php echo $model->getMessage('moduleType');?>

               <label for="moduleStatus">وضعیت ماژول<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('moduleStatus',[1 => 'فعال',0 => 'غیر فعال'],['class' => 'form-control','id' => 'moduleStatus']);?>
               </div>
               <?php echo $model->getMessage('moduleStatus');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="ساخت">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>