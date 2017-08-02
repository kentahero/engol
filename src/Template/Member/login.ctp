<?php
  $this->loadHelper('Form', [
    		'templates' => 'form-templates',
    	]);
?>
<section class="main-content detail-page">
  <section class="container">
    <?php echo $this->Form->create(null,['type'=>'post']);?>
    <?= $this->Form->hidden('group_id')?>
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
          <h2 class="profile-title male bvc">会員ログイン</h2>
        </div>
        <table class="table input-table mb30">
          <tbody>
            <tr>
              <th>Eメール</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('email',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('email')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('password',['class'=>'input']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
        <button type="submit" class="button mb30">
          <span>ログイン</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        <div class="mb30">
		  <p style="text-align:center">パスワードを忘れられた方は<a href="/member/forgot">こちら</a></p>
		</div>
      </section>
      <?php $this->Form->end()?>
    </div>
  </section>
</section>
