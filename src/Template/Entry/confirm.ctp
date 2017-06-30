<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="">トップ</a></li>
        <li class="strong"><a href="">オファー申し込み</a></li>
        <!-- <li><a href="">Hidekiさん</a></li>-->
      </ul>
      <!--
      <a class="bvc" href="./index.html">
        <img class="back-btn bvc" src="./img/icon-back.png">
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
    <div class="profile-area">
      <section class="profile-main-block">
        <?php echo $this->Form->create($entities,['type'=>'post','url'=>['controller'=>'Entry','action'=>'complete']]);?>
        <div class="confirm-msg-area mb10">
          お申込み内容を確認
        </div>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">お申込み情報</h2>
        </div>
        <table class="table input-table mb50">
          <tbody>
            <?php if (!isset($member)) {?>
            <tr>
              <th>メールアドレス</th>
              <td>
                <?=$entities['User']->email?>
              </td>
            </tr>
            <!--
            <tr>
              <th>メール種別</th>
              <td>
                <?=$entities['User']->email_kind_name?>
              </td>
            </tr>
            -->
            <tr>
              <th>パスワード</th>
              <td>
                ●●●●●●●●●●●●
              </td>
            </tr>
            <tr>
              <th>氏名</th>
              <td>
                <?=$entities['User']->first_name?>　<?=$entities['User']->last_name?>
              </td>
            </tr>
            <tr>
              <th>氏名（カナ）</th>
              <td>
                <?=$entities['User']->first_kana?>　<?=$entities['User']->last_kana?>　
              </td>
            </tr>
            <tr>
              <th>ニックネーム</th>
              <td>
                <?=$entities['User']->nickname?>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td>
                <?=$entities['User']->sex_name?>
              </td>
            </tr>
            <tr>
              <th>
                生年月日
              </th>
              <td>
                  <?=$entities['User']->birth->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <?=$entities['User']->postal?>
              </td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td>
                <?=$entities['User']->prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>市区町村</th>
              <td>
                <?=$entities['User']->city_name?>
              </td>
            </tr>
            <tr>
              <th>町名番地</th>
              <td>
                <?=$entities['User']->address1?>
              </td>
            </tr>
            <tr>
              <th>建物名・部屋番号</th>
              <td>
                <?=$entities['User']->address2?>
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>
                <?=$entities['User']->tel?>
              </td>
            </tr>
            <?php }?>
            <tr>
              <th>
                希望日付1
              </th>
              <td>
                <?php if($entities['Offer']->date1)echo $entities['Offer']->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td>
                <?php if($entities['Offer']->date2)echo $entities['Offer']->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>


            <tr>
              <th>
                希望日付3
              </th>
              <td>
                <?php if($entities['Offer']->date3)echo $entities['Offer']->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <tr>
              <th>プレイ場所</th>
              <td>
                <?=$entities['Offer']->course_kind_name?>
              </td>
            </tr>
            <?php if ($entities['Offer']->course_kind == 1) {?>
            <tr>
              <th>ゴルフ場地域</th>
              <td>
                <?=$entities['Offer']->course_prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場名</th>
              <td>
                <?=$entities['Offer']->course_name?>
              </td>
            </tr>
            <?php } else if($entities['Offer']->course_kind == 2) {?>
            <tr>
              <th>練習場地域</th>
              <td>
                <?=$entities['Offer']->training_prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>練習場名</th>
              <td>
                <?=$entities['Offer']->training_name?>
              </td>
            </tr>
            <?php }?>
            <tr>
              <th>お相手にメッセージ</th>
              <td>
                <?=nl2br($entities['Offer']->message)?>
              </td>
            </tr>
          </tbody>
        </table>

        <!--
        <div class="mb20">
          <div class="mb10">
            <span class="">
              <i class="ci img-flag-male"></i>
            </span>
            <h2 class="profile-title male bvc">メッセージ</h2>
          </div>
          <p class="mt20">
            <?=nl2br($data['message'])?>
          </p>
        </div>
        -->

        <button type="submit" class="button">
          <span>オファー申し込みする</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>

      </section>
    </div>
  </section>
</section>
