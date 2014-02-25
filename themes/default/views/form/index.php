<?php
use framework\helpers\Html;
use framework\security\Csrf;
if( $form ) {
       $this->title .= " - {$form->formName}";
?>
<form method="POST">
<section class="main">
          <hgroup><h3><?php echo Html::escape( $form->formName );?></h3></hgroup>
          <p><?php echo Html::escape( $form->formDescription );?></p>
          <div class="line"></div>
          <table class="table">
                <?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
                <tr>
                      <td width="120"><label for="name">نام و نام خانوادگی<span>*</span></label></td><td><?php echo Html::textField('name', ['id' => 'name', 'class' => 'form-control']);?><?php echo $model->getMessage('name');?></td>
                </tr>
                <tr>
                      <td><label for="email">ایمیل<span>*</span></label></td><td><?php echo Html::textField('email', ['id' => 'email', 'class' => 'form-control']);?><?php echo $model->getMessage('email');?></td>
                </tr>
                <tr>
                      <td><label for="mobile">موبایل</label></td><td><?php echo Html::textField('mobile', ['id' => 'mobile', 'class' => 'form-control']);?><?php echo $model->getMessage('mobile');?></td>
                </tr>
                <tr>
                      <td><label for="content">توضیحات</label></td><td><?php echo Html::textArea('content', $form->formContent, ['id' => 'content', 'class' => 'form-control', 'rows' => 3]);?><?php echo $model->getMessage('content');?></td>
                </tr>
                <tr>
                      <td><label for="price">مبلغ (تومان)<span>*</span></label></td><td><?php echo $this->priceField( $form->formPriceType, $form->formPriceValue );?><?php echo $model->getMessage('price');?></td>
                </tr>
                <tr>
                      <td><label for="gateway">درگاه پرداخت<span>*</span></label></td><td><?php echo Html::dropDownList('gateway', Html::convertObjectToDropDownList($modules,'moduleId','moduleName'), ['id' => 'gateway', 'class' => 'form-control']);?><?php echo $model->getMessage('gateway');?></td>
                </tr>
          </table>

			<div class="line"></div>
          <div class="form-group">
                <button type="submit" class="btn my-btn"><span class="glyphicon glyphicon-chevron-left"></span>دریافت فاکتور</button>
          </div>
		
          <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value) {?>
              <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
          <?php }?>
</section>
</form>
<?php } else {?>
<section class="main">
       <p>چیزی یافت نشد</p>
</section>
<?php } ?>