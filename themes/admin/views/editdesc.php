<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ویرایش توضیحات';
if($desc) {
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش توضیحات</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <div style="display:none" class="form-group">
                     <?php echo Html::dropDownList('formId',Html::convertObjectToDropDownList($forms,'formId','formName'),['class' => 'form-control','id' => 'formId'],$desc->afterPaymentFormId);?>
               </div>
               <?php echo $model->getMessage('formId');?>

               <div class="input-group" style="width:100%;margin-bottom:20px;">
                     <?php echo Html::textArea('formContent',$desc->afterPaymentContent,['class' => 'form-control','id' => 'formContent','rows' => 8]);?>
               </div>
               <?php echo $model->getMessage('formContent');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="ویرایش">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>
<script>
CKEDITOR.replace('formContent',{language:'fa',uiColor:"#eeeeee"});
</script>
<?php } else {?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش توضیحات</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>