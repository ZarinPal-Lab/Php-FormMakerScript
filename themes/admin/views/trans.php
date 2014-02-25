<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - تراکنش ها';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>تراکنش ها</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>فرم</th><th>آیتم</th><th>مبلغ</th><th>زمان</th><th>وضعیت</th><th>مشاهده</th></thead>
                     <tbody>
                            <?php foreach($trans as $t) {?>
                                   <tr>
                                          <td><?php echo Html::escape($t->transId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($t->transId);?>"><span></span></label></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($t->transFormId)]);?>">form <?php echo Html::escape($t->transFormId);?></a></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/showitem',['id' => Html::escape($t->transSaveId)]);?>">item <?php echo Html::escape($t->transSaveId);?></a></td>
                                          <td><?php echo $t->transPrice;?></td>
                                          <td><?php echo $this->date($t->transDate);?></td>
                                          <td><?php echo ($t->transStatus == 1 ? '<font color=green>پرداخت شده</font>' : '<font color=red>پرداخت نشده</font>');?></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/showtrans',['id' => Html::escape($t->transId)]);?>"><img src="<?php echo $this->getThemeUrl('img/show.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <input type="submit" class="btn btn-danger" value="حذف تراکنش های انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>