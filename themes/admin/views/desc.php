<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - توضیحات فرم ها';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>توضیحات فرم بعد از پرداخت موفق</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>فرم</th><th>ویرایش</th></thead>
                     <tbody>
                            <?php foreach($desc as $d){?>
                                   <tr>
                                          <td><?php echo Html::escape($d->afterPaymentId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($d->afterPaymentId);?>"><span></span></label></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($d->afterPaymentFormId)]);?>"><?php echo Html::escape($d->afterPaymentFormId);?></a></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/editdesc',['id' => Html::escape($d->afterPaymentId)]);?>"><img src="<?php echo $this->getThemeUrl('img/edit.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <a href="<?php echo Framework::createUrl('admin/newdesc');?>" class="btn my-btn">افزودن</a>
                     <input type="submit" class="btn btn-danger" value="حذف موارد انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>