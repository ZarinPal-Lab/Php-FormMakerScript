<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - افزودن توضیحات';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>افزودن توضیحات</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="formId">انتخاب فرم<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('formId',Html::convertObjectToDropDownList($forms,'formId','formName'),['class' => 'form-control','id' => 'formId']);?>
               </div>
               <?php echo $model->getMessage('formId');?>

               <div class="input-group" style="width:100%;margin-bottom:20px;">
                     <?php echo Html::textArea('formContent','',['id' => 'formContent','rows' => 8]);?>
               </div>
               <?php echo $model->getMessage('formContent');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="افزودن">
              </div>
               </div>
         </div>
       </div>
<script>
CKEDITOR.replace('formContent',{language:'fa',uiColor:"#eeeeee"});
</script>
<?php $this->renderPartial('sidebar');?>
</div>
</form>