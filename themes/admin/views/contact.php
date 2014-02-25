<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - درخواست های تماس';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>درخواست های تماس</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>نام و نام خانوادگی</th><th>ایمیل</th><th>موضوع</th><th>آی پی</th><th>وضعیت</th><td>مشاهده</td></thead>
                     <tbody>
                            <?php foreach($contacts as $contact){?>
                                   <tr>
                                          <td><?php echo Html::escape($contact->contactId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($contact->contactId);?>"><span></span></label></td>
                                          <td><?php echo Html::escape($contact->contactName);?></td>
                                          <td><?php echo Html::escape($contact->contactEmail);?></td>
                                          <td><?php echo mb_substr(Html::escape($contact->contactSubject),0,15,'UTF-8');?>...</td>
                                          <td><?php echo Html::escape($contact->contactIp);?></td>
                                          <td><?php echo ($contact->contactRead == 1 ? '<font color=green>خوانده شده</font>' : '<font color=red>خوانده نشده</font>');?></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/showcontact',['id' => Html::escape($contact->contactId)]);?>"><img src="<?php echo $this->getThemeUrl('img/show.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <input type="submit" class="btn btn-danger" value="حذف موارد انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>