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
    <?php echo $this->Form->create($user,['type'=>'post','url'=>['controller'=>'Entry','action'=>'confirm'],'novalidate' => true]);?>
    <?= $this->Form->hidden('group_id')?>
    <div class="profile-area">
      <section class="profile-main-block">
      　<?php if ($this->Form->error) { ?>
        <div class="error-msg-area mb10">
          入力項目にエラーがあります
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
              <th>Eメール</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('email',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('email')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>Eメール確認</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('email_confirm',['class'=>'input','placeholder'=>'info@engol.jp']);?>
                  <?php echo $this->Form->error('email_confirm')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>メール種別</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->radio('email_kind',[['value'=>'1','text'=>' 携帯'],['value'=>'2','text'=>' PC']]);?>
                  <?php echo $this->Form->error('email_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('password',['class'=>'input']);?>
                  <?php echo $this->Form->error('password')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>パスワード確認</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('password_confirm',['class'=>'input']);?>
                  <?php echo $this->Form->error('password_confirm')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(姓)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('first_name',['class'=>'input','placeholder'=>'田中']);?>
                  <?php echo $this->Form->error('first_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(名)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('last_name',['class'=>'input','placeholder'=>'太郎']);?>
                  <?php echo $this->Form->error('last_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ性）</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('first_kana',['class'=>'input','placeholder'=>'タナカ']);?>
                  <?php echo $this->Form->error('first_kana')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ名）</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('last_kana',['class'=>'input','placeholder'=>'タロウ']);?>
                  <?php echo $this->Form->error('last_kana')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ニックネーム</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('nickname',['class'=>'input','placeholder'=>'たろうくん']);?>
                  <?php echo $this->Form->error('nickname')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->radio('sex',[['value'=>'1','text'=>' 男性'],['value'=>'2','text'=>' 女性']]);?>
                  <?php echo $this->Form->error('sex')?>
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
                  <?php echo $this->Form->select('birth_year',$birth_years,['empty'=>'年','class'=>'select']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('birth_month',$months,['empty'=>'月']);?>
                  </span>
                  <span class="select">
                   <?php echo $this->Form->select('birth_day',$days,['empty'=>'日']);?>
                  </span>
                  <!--<input type="text" value="" class="calendar-picker none"/>-->
                </p>
              </td>
            </tr>
            <tr>
              <th>郵便番号<br/>(ハイフンなし)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('postal',['class'=>'input','placeholder'=>'5634445']);?>
                  <?php echo $this->Form->error('postal')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(都道府県)</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'prefecture_cd'])?>
                    <?php echo $this->Form->error('prefecture_cd')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(市区町村)</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <select id="city_cd" name="city_cd">
                      <option value>市区町村を選択</option>
                    </select>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(町名番地)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('address1',['class'=>'input','placeholder'=>'1丁目2-3']);?>
                  <?php echo $this->Form->error('address1')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(建物名・部屋番号)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('address2',['class'=>'input','placeholder'=>'天神橋マンション201']);?>
                  <?php echo $this->Form->error('address2')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>電話番号<br/>(ハイフンあり)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('tel',['class'=>'input','placeholder'=>'090-1111-2222']);?>
                  <?php echo $this->Form->error('tel')?>
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
                    <?php echo $this->Form->select('offer_year_1',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_month_1',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_day_1',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td class="required">
                <p class="control bvc date">
                  <span class="select">
                    <?php echo $this->Form->select('offer_year_2',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_month_2',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_day_2',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>


            <tr>
              <th>
                希望日付3
              </th>
              <td class="required">
                <p class="control bvc date">
                  <span class="select">
                    <?php echo $this->Form->select('offer_year_3',$offer_years,['empty'=>'年','class'=>'year']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_month_3',$months,['empty'=>'月','class'=>'month']);?>
                  </span>
                  <span class="select">
                    <?php echo $this->Form->select('offer_day_3',$days,['empty'=>'日','class'=>'day']);?>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>
            <tr>
              <th>プレイ場所</th>
              <td class="required">
                <p class="control bvc">
                  <?php echo $this->Form->radio('course_kind',[['value'=>'1','text'=>' ゴルフ場'],['value'=>'2','text'=>' 練習場']]);?>
                  <?php echo $this->Form->error('course_kind')?>
                </p>
              </td>
            </tr>
            <tr id="course_prefecture" style="display:none">
              <th>ゴルフ場地域</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('course_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'course_prefecture_cd'])?>
                  </span>
                </p>
              </td>
            </tr>
            <tr id="course_name" style="display:none">
              <th>ゴルフ場名</th>
              <td class="required">
                <p class="control">
                   <span class="select">
                    <select id="course_id" name="course_id">
                      <option value>ゴルフ場を選択</option>
                    </select>
                  </span>
                  <!--
                  <?php echo $this->Form->text('course_name',['class'=>'input','placeholder'=>'茨木カントリークラブ']);?>
                  -->
                  <?php echo $this->Form->error('course_name')?>
                </p>
              </td>
            </tr>
            <tr id="training_prefecture" style="display:none">
              <th>練習場地域</th>
              <td class="required">
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('training_prefecture_cd',$prefs,['empty'=>'都道府県を選択','id'=>'course_prefecture_cd'])?>
                  </span>
                </p>
              </td>
            </tr>
            <tr id="training_name" style="display:none">
              <th>練習場名</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('training_name',['class'=>'input','placeholder'=>'茨木ゴルフ練習場']);?>
                  <?php echo $this->Form->error('training_name')?>
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
              <textarea class="textarea" placeholder="よろしくお願いいたします"></textarea>
              </p>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mb20 consent-area">
          <h2 class="profile-title male bvc">個人情報保護方針への同意</h2>
          <p class="control">
            <textarea class="textarea" placeholder="Textarea">
山路やまみちを登りながら、こう考えた。
智ちに働けば角かどが立つ。情じょうに棹さおさせば流される。意地を通とおせば窮屈きゅうくつだ。とかくに人の世は住みにくい。
住みにくさが高こうじると、安い所へ引き越したくなる。どこへ越しても住みにくいと悟さとった時、詩が生れて、画えが出来る。
            </textarea>
          </p>
          <p class="control">
            <div class="has-text-centered">
              <input type="checkbox" id="consent"/><label for="consent">同意します</label>
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
