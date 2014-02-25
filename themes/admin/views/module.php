<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - ماژول ها';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>ماژول ها</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>نام</th><th>نام فایل</th><th>نوع ماژول</th><th>وضعیت</th><th>ویرایش</th></thead>
                     <tbody>
                            <?php foreach($modules as $module){?>
                                   <tr>
                                          <td><?php echo Html::escape($module->moduleId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($module->moduleId);?>"><span></span></label></td>
                                          <td><?php echo Html::escape($module->moduleName);?></td>
                                          <td><?php echo Html::escape($module->moduleFileName);?></td>
                                          <td><?php echo ($module->moduleType == 'payment' ? 'پرداخت' : 'اطلاع رسانی');?></td>
                                          <td><?php echo ($module->moduleStatus == 1 ? '<font color=green>فعال</font>' : '<font color=red>غیر فعال</font>');?></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/editmodule',['id' => Html::escape($module->moduleId)]);?>"><img src="<?php echo $this->getThemeUrl('img/edit.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <a href="<?php echo Framework::createUrl('admin/newmodule');?>" class="btn my-btn">افزودن ماژول</a>
                     <input type="submit" class="btn btn-danger" value="حذف ماژول های انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>