<?php
  $this->loadHelper('Form', [
    		'templates' => 'form-templates',
    	]);
?>
<?=$this->Html->script('/js/lib/jquery-ui-1.12.1/datepicker-ja',['block'=>'script']);?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.calendar-picker').datepicker({
        dateFormat : "yy/mm/dd"
        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
        ,showOn: "button"
        ,buttonImageOnly : true
        ,buttonImage : "/img/ic-calendar-32.png"
        ,beforeShow : function(input,inst){
          //開く前に日付を上書き
          var year = $(this).parent().find(".year").val();
          var month = $(this).parent().find(".month").val();
          var date = $(this).parent().find(".day").val();
          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
        },
        onSelect: function(dateText, inst){
          //カレンダー確定時にフォームに反映
          var dates = dateText.split('/');
          $(this).parent().find(".year").val(dates[0]);
          $(this).parent().find(".month").val(dates[1]);
          $(this).parent().find(".day").val(dates[2]);
        }
      });
    });
</script>
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
    <?php echo $this->Form->create($user,['type'=>'post','url'=>['controller'=>'Entry','action'=>'confirm']]);?>
    <?= $this->Form->hidden('group_id')?>
    <div class="profile-area">
      <section class="profile-main-block">
      　<?php if ($this->Form->errors) { ?>
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
                  <?php echo $this->Form->error('mail_kind')?>
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
            <tr>
              <th>パスワード確認</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->password('password_confirm',['class'=>'input']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(姓)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('first_name',['class'=>'input','placeholder'=>'田中']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前(名)</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('last_name',['class'=>'input','placeholder'=>'太郎']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ性）</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('first_kana',['class'=>'input','placeholder'=>'タナカ']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>お名前（カナ名）</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('last_kana',['class'=>'input','placeholder'=>'タロウ']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>ニックネーム</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->text('nickname',['class'=>'input','placeholder'=>'たろうくん']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td class="required">
                <p class="control">
                  <?php echo $this->Form->radio('sex',[['value'=>'1','text'=>' 男性'],['value'=>'2','text'=>' 女性']]);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>
                生年月日
                <!-- <input type="text" value="" class="birthday-picker none"/> -->
<!--                 <script type="text/javascript">
                  $(function() {
                    $('.birthday-picker').datepicker({
                        dateFormat : "yy/mm/dd"
                        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
                        ,showOn: "button"
                        ,buttonImageOnly : true
                        ,buttonImage : "/img/ic-calendar-20.png"
                        ,beforeShow : function(input,inst){
                          //開く前に日付を上書き
                          var year = $(".birthday-year").val();
                          var month = $(".birthday-month").val();
                          var date = $(".birthday-date").val();
                          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
                        },
                        onSelect: function(dateText, inst){
                          //カレンダー確定時にフォームに反映
                          var dates = dateText.split('/');
                          $(".birthday-year").val(dates[0]);
                          $(".birthday-month").val(dates[1]);
                          $(".birthday-date").val(dates[2]);
                        }
                      });
                    });
                </script> -->
              </th>
              <td class="required">
                <p class="control bvc date">
                  <span class="select">
                    <select class="year">
                    <option value='' disabled selected style='display:none;'>年</option>
                    <option value="1950">1950年</option>
                    <option value="2017">2017年</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="month">
                    <option value='' disabled selected style='display:none;'>月</option>
                    <option value="01">1月</option>
                    <option value="02">2月</option>
                    <option value="12">12月</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="day">
                    <option value='' disabled selected style='display:none;'>日</option>
                    <option value="01">1日</option>
                    <option value="31">31日</option>
                    </select>
                    </select>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('postal',['class'=>'input','placeholder'=>'5634445']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(都道府県)</th>
              <td>
                <p class="control">
                  <span class="select">
                    <?php echo $this->Form->select('prefecture_cd',$prefs,['empty'=>'都道府県'])?>
                    <?php echo $this->Form->error('mail_kind')?>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(市区町村)</th>
              <td>
                <p class="control">
                  <span class="select">
                  </select>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(町名番地)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('address1',['class'=>'input','placeholder'=>'1丁目2-3']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>住所(建物名・部屋番号)</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('address2',['class'=>'input','placeholder'=>'天神橋マンション201']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('tel',['class'=>'input','placeholder'=>'090-1111-2222']);?>
                  <?php echo $this->Form->error('mail_kind')?>
                </p>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <th>
                希望日付1
<!--                 <input type="text" value="" class="preferred-date1-picker none"/>
                <script type="text/javascript">
                  $(function() {
                    $('.preferred-date1-picker').datepicker({
                        dateFormat : "yy/mm/dd"
                        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
                        ,showOn: "button"
                        ,buttonImageOnly : true
                        ,buttonImage : "/img/ic-calendar-25.png"
                        ,beforeShow : function(input,inst){
                          //開く前に日付を上書き
                          var year = $(".preferred-date1-year").val();
                          var month = $(".preferred-date1-month").val();
                          var date = $(".preferred-date1-date").val();
                          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
                        },
                        onSelect: function(dateText, inst){
                          //カレンダー確定時にフォームに反映
                          var dates = dateText.split('/');
                          $(".preferred-date1-year").val(dates[0]);
                          $(".preferred-date1-month").val(dates[1]);
                          $(".preferred-date1-date").val(dates[2]);
                        }
                      });
                    });
                </script> -->
              </th>
              <td class="required">
                <p class="control bvc date">
<!--                   <input type="text" value="" class="input wid-per20 preferred-date1-year" size="4" /> <span class="input-label">年</span>
                  <input type="text" value="" class="input wid-per20 preferred-date1-month" size="4" /> <span class="input-label">月</span>
                  <input type="text" value="" class="input wid-per20 preferred-date1-date" size="4" /> <span class="input-label">日</span> -->
                  <span class="select">
                    <select class="year">
                    <option value='' disabled selected style='display:none;'>年</option>
                    <option value="1950">1950年</option>
                    <option value="2017">2017年</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="month">
                    <option value='' disabled selected style='display:none;'>月</option>
                    <option value="01">1月</option>
                    <option value="12">12月</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="day">
                    <option value='' disabled selected style='display:none;'>日</option>
                    <option value="01">1日</option>
                    <option value="31">31日</option>
                    </select>
                    </select>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
<!--                 <input type="text" value="" class="preferred-date2-picker none"/>
                <script type="text/javascript">
                  $(function() {
                    $('.preferred-date2-picker').datepicker({
                        dateFormat : "yy/mm/dd"
                        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
                        ,showOn: "button"
                        ,buttonImageOnly : true
                        ,buttonImage : "/img/ic-calendar-25.png"
                        ,beforeShow : function(input,inst){
                          //開く前に日付を上書き
                          var year = $(".preferred-date2-year").val();
                          var month = $(".preferred-date2-month").val();
                          var date = $(".preferred-date2-date").val();
                          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
                        },
                        onSelect: function(dateText, inst){
                          //カレンダー確定時にフォームに反映
                          var dates = dateText.split('/');
                          $(".preferred-date2-year").val(dates[0]);
                          $(".preferred-date2-month").val(dates[1]);
                          $(".preferred-date2-date").val(dates[2]);
                        }
                      });
                    });
                </script> -->
              </th>
              <td class="required">
                <p class="control bvc date">
<!--                   <input type="text" value="" class="input wid-per20 preferred-date2-year" size="4" /> <span class="input-label">年</span>
                  <input type="text" value="" class="input wid-per20 preferred-date2-month" size="4" /> <span class="input-label">月</span>
                  <input type="text" value="" class="input wid-per20 preferred-date2-date" size="4" /> <span class="input-label">日</span> -->
                  <span class="select">
                    <select class="year">
                    <option value='' disabled selected style='display:none;'>年</option>
                    <option value="1950">1950年</option>
                    <option value="2017">2017年</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="month">
                    <option value='' disabled selected style='display:none;'>月</option>
                    <option value="01">1月</option>
                    <option value="12">12月</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="day">
                    <option value='' disabled selected style='display:none;'>日</option>
                    <option value="01">1日</option>
                    <option value="31">31日</option>
                    </select>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>


            <tr>
              <th>
                希望日付3
<!--                 <input type="text" value="" class="preferred-date3-picker none"/>
                <script type="text/javascript">
                  $(function() {
                    $('.preferred-date3-picker').datepicker({
                        dateFormat : "yy/mm/dd"
                        ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
                        ,showOn: "button"
                        ,buttonImageOnly : true
                        ,buttonImage : "/img/ic-calendar-25.png"
                        ,beforeShow : function(input,inst){
                          //開く前に日付を上書き
                          var year = $(".preferred-date3-year").val();
                          var month = $(".preferred-date3-month").val();
                          var date = $(".preferred-date3-date").val();
                          $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
                        },
                        onSelect: function(dateText, inst){
                          //カレンダー確定時にフォームに反映
                          var dates = dateText.split('/');
                          $(".preferred-date3-year").val(dates[0]);
                          $(".preferred-date3-month").val(dates[1]);
                          $(".preferred-date3-date").val(dates[2]);
                        }
                      });
                    });
                </script> -->
              </th>
              <td class="required">
                <p class="control bvc date">
<!--                   <input type="text" value="" class="input wid-per20 preferred-date3-year" size="4" /> <span class="input-label">年</span>
                  <input type="text" value="" class="input wid-per20 preferred-date3-month" size="4" /> <span class="input-label">月</span>
                  <input type="text" value="" class="input wid-per20 preferred-date3-date" size="4" /> <span class="input-label">日</span> -->
                  <span class="select">
                    <select class="year">
                    <option value='' disabled selected style='display:none;'>年</option>
                    <option value="1950">1950年</option>
                    <option value="2017">2017年</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="month">
                    <option value='' disabled selected style='display:none;'>月</option>
                    <option value="01">1月</option>
                    <option value="12">12月</option>
                    </select>
                  </span>
                  <span class="select">
                    <select class="day">
                    <option value='' disabled selected style='display:none;'>日</option>
                    <option value="01">1日</option>
                    <option value="31">31日</option>
                    </select>
                  </span>
                  <input type="text" value="" class="calendar-picker none"/>
                </p>
              </td>
            </tr>


            <tr>
              <th>プレイ場所</th>
              <td>
                <p class="control bvc">
                  <input type="checkbox" id="round"/><label for="round">ゴルフ場</label>
                  <input type="checkbox" id="practice"/><label for="practice">練習場</label>
                </p>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場地域</th>
              <td>
                <p class="control">
                  <span class="select">
                    <select>
                    <option value='' disabled selected style='display:none;'>地域</option>
                    <option value="">北海道</option>
                    <option value="">東北</option>
                    </select>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場名</th>
              <td>
                <p class="control">
                  <?php echo $this->Form->text('course_name',['class'=>'input','placeholder'=>'茨木カントリークラブ']);?>
                  <?php echo $this->Form->error('course_name')?>
                </p>
              </td>
            </tr>
            <tr>
              <th>練習場地域</th>
              <td>
                <p class="control">
                  <span class="select">
                    <select>
                    <option value='' disabled selected style='display:none;'>地域</option>
                    <option value="">北海道</option>
                    <option value="">東北</option>
                    </select>
                  </span>
                </p>
              </td>
            </tr>
            <tr>
              <th>練習場名</th>
              <td>
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
