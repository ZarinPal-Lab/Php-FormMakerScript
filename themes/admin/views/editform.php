<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ویرایش فرم';
if($form) {
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ویرایش فرم</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <label for="formName">عنوان فرم<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('formName',['class' => 'form-control','id' => 'formName','value' => $form->formName]);?>
               </div>
               <?php echo $model->getMessage('formName');?>

               <label for="formDescription">توضیحات فرم<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('formDescription',['class' => 'form-control','id' => 'formDescription','value' => $form->formDescription]);?>
               </div>
               <?php echo $model->getMessage('formDescription');?>

               <label for="formTag">برچسب فرم<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('formTag',['class' => 'form-control','id' => 'formTag','value' => $form->formTag]);?>
               </div>
               <?php echo $model->getMessage('formTag');?>

               <label for="formContent">مقدار پیشفرض فیلد توضیحات</label>
               <div class="form-group">
                     <?php echo Html::textArea('formContent',$form->formContent,['class' => 'form-control','id' => 'formContent']);?>
               </div>
               <?php echo $model->getMessage('formContent');?>

               <label for="formPriceType">نوع مبلغ<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('formPriceType',['text' => 'انتخاب کاربر','select' => 'منوی انتخابی'],['id' => 'formPriceType','class' => 'form-control'],$form->formPriceType);?>
               </div>
               <?php echo $model->getMessage('formPriceType');?>

               <div class="alert alert-info">در صورت انتخاب منوی انتخابی مبلغ را با , از هم جدا کنید</div>

               <label for="formPriceValue">مقدار مبلغ(تومان)<span>*</span></label>
               <div class="form-group">
                     <?php echo Html::textField('formPriceValue',['class' => 'form-control','id' => 'formPriceValue','value' => $form->formPriceValue]);?>
               </div>
               <?php echo $model->getMessage('formPriceValue');?>

               <label for="formStatus">وضعیت <span>*</span></label>
               <div class="form-group">
                     <?php echo Html::dropDownList('formStatus',[1 => 'فعال',0 => 'غیر فعال'],['id' => 'formStatus','class' => 'form-control'],(int)$form->formStatus);?>
               </div>
               <?php echo $model->getMessage('formStatus');?>

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
               <hgroup><h3>ویرایش فرم</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>