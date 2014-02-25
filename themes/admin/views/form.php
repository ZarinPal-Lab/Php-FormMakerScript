<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - فرم ها';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>فرم ها</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>عنوان فرم</th><th>برچسب</th><th>مبلغ</th><th>وضعیت</th><th>ویرایش</th></thead>
                     <tbody>
                            <?php foreach($forms as $form) {?>
                            <tr>
                                   <td><?php echo Html::escape($form->formId);?></td>
                                   <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($form->formId);?>"><span></span></label></td>
                                   <td><a target="_blank" href="<?php echo Framework::createUrl('form/index',['id' => Html::escape($form->formId),'tag' => $form->formTag]);?>"><?php echo Html::escape($form->formName);?></a></td>
                                   <td><?php echo Html::escape($form->formTag);?></td>
                                   <td><?php echo Html::escape($form->formPriceValue);?></td>
                                   <td><?php echo ($form->formStatus == 1 ? '<font color=green>فعال</font>' : '<font color=red>غیر فعال</font>');?></td>
                                   <td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($form->formId)]);?>"><img src="<?php echo $this->getThemeUrl('img/edit.png');?>"></a></td>
                            </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <a href="<?php echo Framework::createUrl('admin/newform');?>" class="btn my-btn">ساخت فرم جدید</a>
                     <input type="submit" class="btn btn-danger" value="حذف فرم های انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>