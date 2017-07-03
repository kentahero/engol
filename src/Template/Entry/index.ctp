<?php $this->assign('title','オファー申し込みページ')?>
<?php $this->assign('description','エンゴルはゴルフのお相手を気軽に探せるサイトです。ゴルフ場でラウンドしたいけど相手が居なくて困っている方。複数人で楽しくプレイしたい方。教えてもらう相手を探している方はすぐにお相手が見つかります');?>
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
        <li class="strong"><a href="/profile/search">オファー申し込み</a></li>
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
    <div class="entry-disp-area">
      <?= $this->element('profile')?>
    </div>
  </section>
  <section class="container">
    <?php if (!isset($member)) { ?>
    <a href="/member/login" class="button mb30" style="width:95%; max-width:1024px; ">
      <span style="font-size:0.9em">既に会員登録されている方はコチラ</span>
      <span class="icon is-medium right" style="vertical-align: baseline">
        <i class="ci img-next"></i>
      </span>
    </a>
    <?php } ?>
    <?php echo $this->Form->create($entities,['type'=>'post','url'=>['controller'=>'Entry','action'=>'confirm'],'novalidate' => true]);?>
    <?= $this->Form->hidden('Offer.receive_group_id')?>
    <div class="profile-area">
      <section class="profile-main-block">
      　<?php if (isset($error)) { ?>
        <div class="error-msg-area mb10">
          入力項目にエラーがあります。各項目を確認の上、再度入力して下さい。
        </div>
        <?php }?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">オファー申し込み情報</h2>
        </div>
        <table class="table input-table mb50">
          <tbody>
            <?php if (!isset($member)) { ?>
            <tr>
              <th>メールアドレス</th>
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
            <!--
            <tr>
              <th>メール種別</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->radio('User.email_kind',[['value'=>'1','text'=>' 携帯'],['value'=>'2','text'=>' PC']]);?>
                  <?php echo $this->Form->error('User.email_kind')?>
                </p>
              </td>
            </tr>
             -->
            <tr>
              <th>パスワード</th>
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
              <th>お名前(姓)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.first_name',['class'=>'input','placeholder'=>'田中']);?>
                  <?php echo $this->Form->error('User.first_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(名)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.last_name',['class'=>'input','placeholder'=>'太郎']);?>
                  <?php echo $this->Form->error('User.last_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ性）</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.first_kana',['class'=>'input','placeholder'=>'タナカ']);?>
                  <?php echo $this->Form->error('User.first_kana')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ名）</th>
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
                生年月日
                <!-- <input type="text" value="" class="birthday-picker none"/> -->
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
              <th>郵便番号<br/>(ハイフンなし)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.postal',['class'=>'input','placeholder'=>'5634445','id'=>'postal','style'=>'width:50%']);?>
                  <input type="button" value="住所検索" id='search_postal'/>
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
              <th>住所(市区町村)</th>
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
              <th>住所(町名番地)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('User.address1',['class'=>'input','placeholder'=>'1丁目2-3','id'=>'address1']);?>
                  <?php echo $this->Form->error('User.address1')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(建物名・部屋番号)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('User.address2',['class'=>'input','placeholder'=>'天神橋マンション201']);?>
                  <?php echo $this->Form->error('User.address2')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>電話番号<br/>(ハイフンなし)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('User.tel',['class'=>'input','placeholder'=>'09011112222']);?>
                  <?php echo $this->Form->error('User.tel')?>
                </p>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <th>
                希望日付1
              </th>
              <td class="required">
                <p class="control bvc date">
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.0.year',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.0.month',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.0.day',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                  <?php echo $this->Form->error('Offer.date1')?>
                </p>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td>
                <p class="control bvc date">
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.1.year',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.1.month',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.1.day',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                  <?php echo $this->Form->error('Offer.date2')?>
                </p>
              </td>
            </tr>


            <tr>
              <th>
                希望日付3
              </th>
              <td>
                <p class="control bvc date">
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.2.year',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.2.month',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('Offer.date.2.day',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                  <?php echo $this->Form->error('Offer.date3')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>プレイ場所</th>
              <td class="required">
                <p class="control bvc">
                  <?php echo $this->Form->radio('Offer.course_kind',[['value'=>'1','text'=>' ゴルフ場'],['value'=>'2','text'=>' 練習場']]);?>
                  <?php echo $this->Form->error('Offer.course_kind')?>
                </p>
              </td>
            </tr>
            <tr id="course_prefecture" style="display:none">
              <th>ゴルフ場地域</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('Offer.course_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'course_prefecture_cd'])?>
                    <?php echo $this->Form->error('Offer.course_prefecture_cd')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr id="course_name_tr" style="display:none">
              <th>ゴルフ場名</th>
              <td class="required">
                <p class="control">
                   <span class="select">
                    <?php echo $this->Form->select('Offer.course_name',$courses,['empty'=>'ゴルフ場を選択','id'=>'course_name'])?>
                  </span>
                  <?php echo $this->Form->error('Offer.course_name')?>
                </p>
              </td>
            </tr>
			<tr id="course_name_other" style="display:none">
              <th>ゴルフ場名（リストにない場合）</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('Offer.course_name_other',['class'=>'input','placeholder'=>'茨木カントリークラブ']);?>
                  <?php echo $this->Form->error('Offer.course_other_name')?>
                </p>
              </td>
            </tr>
            <tr id="training_prefecture" style="display:none">
              <th>練習場地域</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('Offer.training_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'course_prefecture_cd'])?>
                    <?php echo $this->Form->error('Offer.training_prefecture_cd')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr id="training_name" style="display:none">
              <th>練習場名</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('Offer.training_name',['class'=>'input','placeholder'=>'茨木ゴルフ練習場']);?>
                  <?php echo $this->Form->error('Offer.training_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <td  colspan="2>
              <span class="">
                <i class="ci img-flag-male"></i>
              </span>
              <h2 class="profile-title male bvc">お相手に一言メッセージ</h2>
              <p class="control">
              <?php echo $this->Form->textarea('Offer.message',['class'=>'textarea','placeholder'=>'よろしくお願いいたします']);?>
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
