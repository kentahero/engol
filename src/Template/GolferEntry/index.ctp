<?php
  $this->loadHelper('Form', [
    		'templates' => 'form-templates',
    	]);
?>
<?=$this->Html->css('/js/lib/jquery-ui-1.12.1/jquery-ui.min',['block'=>'css']);?>
<?=$this->Html->script('/js/lib/jquery-ui-1.12.1/datepicker-ja',['block'=>'script']);?>
<?=$this->Html->script('holiday_check',['block'=>'script']);?>
<?=$this->Html->script('entry',['block'=>'script']);?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.calendar-picker').datepicker({
        dateFormat : "yy/mm/dd"
        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
        ,showOn: "button"
        ,buttonImageOnly : true
        ,buttonImage : "/img/ic-calendar-32.png"
        ,minDate: '4d'
        ,maxDate: '30d'
		,beforeShowDay: function(date) {
       	  var result;
          var dd = date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + date.getDate();
          var hName = ktHolidayName(dd);
          if(hName != "") {
          	result = [true, "date-holiday", hName];
          } else {
          	switch (date.getDay()) {
              case 0: //日曜日
               	result = [true, "date-holiday"];
               	break;
              case 6: //土曜日
               	result = [true, "date-saturday"];
                break;
              default:
               	result = [true];
                break;
              }
          }
          return result;
        }
        ,beforeShow : function(input,inst){
          //開く前に日付を上書き
          var year = $(this).parent().find(".year").val();
          var month = $(this).parent().find(".month").val();
          var date = $(this).parent().find(".day").val();
          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
        }
        ,onSelect: function(dateText, inst){
          //カレンダー確定時にフォームに反映
          var dates = dateText.split('/');
          $(this).parent().find(".year").val(dates[0]);
          $(this).parent().find(".month").val(dates[1]);
          $(this).parent().find(".day").val(dates[2]);
        }
      });
    });
</script>
<style>
    .date-holiday .ui-state-default {
        background-image:none;
        background-color:#FF9999;
    }
    .date-saturday .ui-state-default {
        background-image:none;
        background-color:#66CCFF;
    }
    body {
        margin:0;
        padding:0;
        font-family:Arial,sans-serif;
        font-size:0.8em;
    }
</style>
<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="/">トップ</a></li>
        <li class="strong"><a href="/profile/search">ゴルファー登録</a></li>
        <!-- <li><a href="">入力</a></li> -->
      </ul>
      <!--
      <a class="bvc" href="./index.html">
        <img class="back-btn bvc" src="/img/icon-back.png">
        <span class="back-btn-name">戻る</span>
      </a>
      -->
    </section>
<!--     <section class="detail-title">
      <p class="mb10">
        <span class="icon-left">
          <i class="ci img-ball"></i>
        </span>
        プロフィール
      </p>
    </section> -->
  </section>
  <section class="container">
    <?php if (!isset($member)) { ?>
    <a href="/member/login" class="button mb30" style="width:95%; max-width:1024px; ">
      <span style="font-size:0.9em">既に会員登録されている方はコチラ</span>
      <span class="icon is-medium right" style="vertical-align: baseline">
        <i class="ci img-next"></i>
      </span>
    </a>
    <div class="has-text-centered">※既に会員登録されている方は個人情報の入力を省略出来ます</div>
    <?php } ?>
    <?php echo $this->Form->create($entities,['type'=>'file','url'=>['controller'=>'GolferEntry','action'=>'confirm'],'novalidate' => true]);?>
    <div class="profile-area">
      <section class="profile-main-block">
      　<?php if (isset($error)) { ?>
        <div class="error-msg-area mb10">
          入力項目にエラーがあります。各項目を確認の上、再度入力して下さい。
        </div>
        <?php }?>
        <?php if (!isset($member)) { ?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">個人情報</h2>
        </div>
        <table class="table input-table">
          <tbody style="border-bottom:0px">
            <tr>
              <th>メールアドレス</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.email',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('User.email')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>メールアドレス確認</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.email_confirm',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('User.email_confirm')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>パスワード</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('User.password',['class'=>'input']);?>
                  <?php echo $this->Form->error('User.password')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>パスワード確認</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('User.password_confirm',['class'=>'input']);?>
                  <?php echo $this->Form->error('User.password_confirm')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(姓)</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.first_name',['class'=>'input','placeholder'=>'田中']);?>
                  <?php echo $this->Form->error('User.first_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(名)</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.last_name',['class'=>'input','placeholder'=>'太郎']);?>
                  <?php echo $this->Form->error('User.last_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ性）</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.first_kana',['class'=>'input','placeholder'=>'タナカ']);?>
                  <?php echo $this->Form->error('User.first_kana')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ名）</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.last_kana',['class'=>'input','placeholder'=>'タロウ']);?>
                  <?php echo $this->Form->error('User.last_kana')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ニックネーム</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.nickname',['class'=>'input','placeholder'=>'たろうくん']);?>
                  <?php echo $this->Form->error('User.nickname')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->radio('User.sex',[['value'=>'1','text'=>' 男性'],['value'=>'2','text'=>' 女性']]);?>
                  <?php echo $this->Form->error('User.sex')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>
                生年月日</br>(公開されません)
              </th>
              <td class="required">
                <p class="control bvc date">
                  <span class="select">
                  <?php echo $this->Form->select('User.birth_year',$birth_years,['empty'=>'年','class'=>'select']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('User.birth_month',$months,['empty'=>'月']);?>
                  </span>
                  <span class="select">
                   <?php echo $this->Form->select('User.birth_day',$days,['empty'=>'日']);?>
                  </span>
                  <!--<input type="text" value="" class="calendar-picker none"/>-->
                  <?php echo $this->Form->error('User.birth')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>郵便番号(ハイフンなし)<br/>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.postal',['class'=>'input','placeholder'=>'5634445']);?>
                  <?php echo $this->Form->error('User.postal')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(都道府県)</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('User.prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'prefecture_cd'])?>
                    <?php echo $this->Form->error('User.prefecture_cd')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(市区町村)</br>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('User.city_cd',$cities,['empty'=>'市区町村を選択','id'=>'city_cd'])?>
                    <?php echo $this->Form->error('User.city_cd')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(町名番地)</br>(公開されません)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('User.address1',['class'=>'input','placeholder'=>'1丁目2-3']);?>
                  <?php echo $this->Form->error('User.address1')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(建物名・部屋番号)</br>(公開されません)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('User.address2',['class'=>'input','placeholder'=>'天神橋マンション201']);?>
                  <?php echo $this->Form->error('User.address2')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>電話番号(ハイフンなし)<br/>(公開されません)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.tel',['class'=>'input','placeholder'=>'09011112222']);?>
                  <?php echo $this->Form->error('User.tel')?>
                </p>
              </td>
            </tr>
         </tbody>
        </table>
        <?php } ?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">プロフィール写真</h2>
        </div>
        <table class="table input-table">
          <tbody style="border-bottom:0px">
            <tr>
              <th>写真１</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->file('CompanionInfo.image1',['accept'=>'image/*']);?>
                  <?php echo $this->Form->error('CompanionInfo.image1')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>写真２</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->file('CompanionInfo.image2',['accept'=>'image/*']);?>
                  <?php echo $this->Form->error('CompanionInfo.image2')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>写真３</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->file('CompanionInfo.image3',['accept'=>'image/*']);?>
                  <?php echo $this->Form->error('CompanionInfo.image3')?>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">ゴルファー情報</h2>
        </div>
        <table class="table input-table">
          <tbody style="border-bottom:0px">
            <tr>
              <th>ＰＲ</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->textarea('CompanionInfo.pr',['class'=>'textarea','placeholder'=>'それほどうまくありませんが楽しく回りましょう','row'=>3]);?>
                  <?php echo $this->Form->error('CompanionInfo.pr')?>
                </p>
              </td>
            </tr>
			<tr>
              <th>平均スコア</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('CompanionInfo.average_score',['class'=>'input','placeholder'=>'95']);?>
                  <?php echo $this->Form->error('CompanionInfo.average_score')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ラウンド可能曜日</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.0',['class'=>'checkbox','value'=>'月','id'=>'round_week1']);?><label for="round_week1">月</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.1',['class'=>'checkbox','value'=>'火','id'=>'round_week2']);?><label for="round_week2">火</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.2',['class'=>'checkbox','value'=>'水','id'=>'round_week3']);?><label for="round_week3">水</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.3',['class'=>'checkbox','value'=>'木','id'=>'round_week4']);?><label for="round_week4">木</label><br/>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.4',['class'=>'checkbox','value'=>'金','id'=>'round_week5']);?><label for="round_week5">金</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.5',['class'=>'checkbox','value'=>'土','id'=>'round_week6']);?><label for="round_week6">土</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.6',['class'=>'checkbox','value'=>'日','id'=>'round_week7']);?><label for="round_week7">日</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.round_week_ar.7',['class'=>'checkbox','value'=>'ALL','id'=>'round_week8']);?><label for="round_week8">いつでも</label>
                  <?php echo $this->Form->error('CompanionInfo.round_week')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>練習場可能曜日</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.0',['class'=>'checkbox','value'=>'月','id'=>'training_week1']);?><label for="training_week1">月</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.1',['class'=>'checkbox','value'=>'火','id'=>'training_week2']);?><label for="training_week2">火</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.2',['class'=>'checkbox','value'=>'水','id'=>'training_week3']);?><label for="training_week3">水</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.3',['class'=>'checkbox','value'=>'木','id'=>'training_week4']);?><label for="training_week4">木</label><br/>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.4',['class'=>'checkbox','value'=>'金','id'=>'training_week5']);?><label for="training_week5">金</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.5',['class'=>'checkbox','value'=>'土','id'=>'training_week6']);?><label for="training_week6">土</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.6',['class'=>'checkbox','value'=>'日','id'=>'training_week7']);?><label for="training_week7">日</label>
                  <?php echo $this->Form->checkbox('CompanionInfo.training_week_ar.7',['class'=>'checkbox','value'=>'ALL','id'=>'training_week8']);?><label for="training_week8">いつでも</label>
                  <?php echo $this->Form->error('CompanionInfo.training_week')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場エリア</th>
              <td class="required">
                <p class="control">
                <span class="select">
                  <?php echo $this->Form->select('CompanionInfo.course_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'prefecture_cd'])?>
                  <?php echo $this->Form->error('CompanionInfo.course_prefecture_cd')?>
                </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>練習場エリア</th>
              <td class="required">
                <p class="control">
                <span class="select">
                  <?php echo $this->Form->select('CompanionInfo.training_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'prefecture_cd'])?>
                  <?php echo $this->Form->error('CompanionInfo.training_prefecture_cd')?>
                </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>ゴルフ歴</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('CompanionInfo.history',['class'=>'input','placeholder'=>'3年']);?>
                  <?php echo $this->Form->error('CompanionInfo.history')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ご職業</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('CompanionInfo.job',['class'=>'input','placeholder'=>'会社員']);?>
                  <?php echo $this->Form->error('CompanionInfo.job')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>設定料金</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('CompanionInfo.amount',['class'=>'input','placeholder'=>'10000']);?>
                  <?php echo $this->Form->error('CompanionInfo.amount')?>
                </p>
              </td>
            </tr>
            <tr>
              <th colspan="2" style="font-size:.8em">※設定料金を設定するとオファーが減る可能性がありますのでご注意ください。主にコーチなどの方が対象です。</th>
            <tr>
              <th>プレイ費</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->radio('CompanionInfo.play_amount_kind',[['value'=>'1','text'=>' 自身で負担'],['value'=>'2','text'=>'相手に負担してもらう']]);?>
                  <?php echo $this->Form->error('CompanionInfo.play_amount_kind')?>
                </p>
              </td>
            </tr>
             <tr>
              <th colspan="2" style="font-size:.8em">※プレイ費をお相手に負担して頂くとオファーが減る可能性がありますのでご注意ください。</th>
            <tr>
            <tr>
              <th>ペアの方のメールアドレス</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('CompanionInfo.pair_email',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('CompanionInfo.pair_email')?>
                </p>
              </td>
            </tr>
            <tr>
              <th colspan="2" style="font-size:.8em">※ペアを組む場合、相手の方が先にゴルファー登録している必要があります。</th>
            <tr>
          </tbody>
        </table>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">お振込先情報</h2>
          <p style="font-size:.8em">※設定料金を設定した場合やプレイ費を相手方に負担を希望する場合入力して下さい</p>
          <p style="font-size:.8em">※ご入力の口座に設定料金、プレイ費のお振込を行いますのでお間違いのないようお願いいたします</p>
        </div>
        <table class="table input-table mb50">
          <tbody style="border-bottom:0px">
          <tr>
            <th>金融機関名</br>(公開されません)</th>
            <td class="required">
              <p class="control">
			    <?php echo $this->Form->text('CompanionInfo.payment_bank',['class'=>'input','placeholder'=>'三井住友銀行']);?>
                <?php echo $this->Form->error('CompanionInfo.payment_bank')?>
              </p>
            </td>
          </tr>
          <tr>
            <th>支店名</br>(公開されません)</th>
            <td class="required">
              <p class="control">
			    <?php echo $this->Form->text('CompanionInfo.payment_shop_name',['class'=>'input','placeholder'=>'天満支店']);?>
                <?php echo $this->Form->error('CompanionInfo.payment_shop_name')?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座種別</br>(公開されません)</th>
            <td class="required">
              <p class="control">
			    <?php echo $this->Form->radio('CompanionInfo.payment_bank_kind',[['value'=>'1','text'=>'普通'],['value'=>'2','text'=>'当座']]);?>
                  <?php echo $this->Form->error('CompanionInfo.payment_bank_kind')?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座番号</br>(公開されません)</th>
            <td class="required">
              <p class="control">
			    <?php echo $this->Form->text('CompanionInfo.payment_no',['class'=>'input','placeholder'=>'12345678']);?>
                <?php echo $this->Form->error('CompanionInfo.payment_no')?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座名義</br>(公開されません)</th>
            <td class="required">
              <p class="control">
			    <?php echo $this->Form->text('CompanionInfo.payment_name',['class'=>'input','placeholder'=>'ヤマダ　タロウ']);?>
                <?php echo $this->Form->error('CompanionInfo.payment_name')?>
              </p>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="mb20 consent-area">
          <h2 class="profile-title male bvc">個人情報保護方針への同意</h2>
          <p class="control">
            <textarea class="textarea">
            <?= $this->element('privacy_text');?>
            </textarea>
          </p>
          <p class="control">
            <div class="has-text-centered">
              <?php echo $this->Form->checkbox('User.agree',['id'=>'consent'])?>
              <label for="consent">同意します</label>
              <?php echo $this->Form->error('User.agree')?>
            </div>
          </p>
        </div>

        <button type="submit" class="button">
          <span>入力内容を確認する</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
      </section>
      <?php $this->Form->end()?>
    </div>
  </section>
</section>
