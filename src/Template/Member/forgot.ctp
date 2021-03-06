<?php
  $this->loadHelper('Form', [
    		'templates' => 'form-templates',
    	]);
?>
<section class="main-content detail-page">
  <section class="container">
    <?php echo $this->Form->create(null,['type'=>'post']);?>
    <div class="profile-area">
      <section class="profile-main-block">
      　<?php if (isset($error)) { ?>
        <div class="error-msg-area mb10">
          <?=$error?>
        </div>
        <?php }?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">パスワード再発行</h2>
        </div>
        <table class="table input-table mb30">
          <tbody>
            <tr>
              <th>メールアドレス</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('email',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('email')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>生年月日</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('birth',['class'=>'input','placeholder'=>'19800704']);?>
                  <?php echo $this->Form->error('birth')?>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
        <button type="submit" class="button mb30">
          <span>再発行</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
      </section>
      <?php $this->Form->end()?>
    </div>
  </section>
</section>
