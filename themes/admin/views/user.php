<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - مدیریت مدیران';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>مدیریت مدیران</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>نام کاربری </th><th>ایمیل</th><th>ویرایش</th></thead>
                     <tbody>
                            <?php foreach($users as $user) {?>
                                   <tr>
                                          <td><?php echo Html::escape($user->userId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($user->userId);?>"><span></span></label></td>
                                          <td><?php echo Html::escape($user->userName);?></td>
                                          <td><?php echo Html::escape($user->userEmail);?></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/edituser',['id' => Html::escape($user->userId)]);?>"><img src="<?php echo $this->getThemeUrl('img/edit.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <a href="<?php echo Framework::createUrl('admin/newuser');?>" class="btn my-btn">ساخت مدیر جدید</a>
                     <input type="submit" class="btn btn-danger" value="حذف مدیران انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>