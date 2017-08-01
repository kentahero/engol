<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="">トップ</a></li>
        <li class="strong"><a href="">ゴルファー登録</a></li>
        <!-- <li><a href="">Hidekiさん</a></li>-->
      </ul>
      <!--
      <a class="bvc" href="./index.html">
        <img class="back-btn bvc" src="./img/icon-back.png">
        <span class="back-btn-name">戻る</span>
      </a>
       -->
    </section>
  </section>
  <section class="container">
    <div class="profile-area">
      <section class="profile-main-block">
        <?php echo $this->Form->create($entities,['type'=>'post','url'=>['controller'=>'MemberEdit','action'=>'complete']]);?>
        <div class="confirm-msg-area mb10">
          登録内容を確認
        </div>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">個人情報</h2>
        </div>
        <table class="table input-table mb50">
          <tbody style="border-bottom:0px">
            <tr>
              <th>メールアドレス</th>
              <td>
                <?=$entities['User']->email?>
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
		  </tbody>
		</table>
		<?php if ($entities['User']->companion_flg == '1') {?>
		<div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">プロフィール画像</h2>
        </div>
        <table class="table input-table mb50">
          <tbody style="border-bottom:0px">
            <tr>
              <th>画像1</th>
              <td class="required">
                <img src="<?=$entities['CompanionInfo']['image_url1']?>" width="200"/>
              </td>
            </tr>
            <?php if($entities['CompanionInfo']['image_url2']) {?>
            <tr>
              <th>画像2</th>
              <td>
                <img src="<?=$entities['CompanionInfo']['image_url2']?>" width="200"/>
              </td>
            </tr>
            <?php }?>
            <?php if($entities['CompanionInfo']['image_url3']) {?>
            <tr>
              <th>画像3</th>
              <td>
                <img src="<?=$entities['CompanionInfo']['image_url3']?>" width="200"/>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">ゴルファー情報</h2>
        </div>
        <table class="table input-table mb50">
          <tbody style="border-bottom:0px">
            <tr>
              <th>ＰＲ</th>
              <td class="required">
                <?=nl2br($entities['CompanionInfo']->pr)?>
              </td>
            </tr>
            <tr>
              <th>平均スコア</th>
              <td class="required">
                <?=$entities['CompanionInfo']->average_score?>
              </td>
            </tr>
            <tr>
              <th>ラウンド曜日</th>
              <td class="required">
                <?=$entities['CompanionInfo']->round_week_str?>
              </td>
            </tr>
            <tr>
              <th>練習場曜日</th>
              <td class="required">
                <?=$entities['CompanionInfo']->training_week_str?>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場エリア</th>
              <td class="required">
                <?=$entities['CompanionInfo']->course_prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>練習場エリア</th>
              <td class="required">
                <?=$entities['CompanionInfo']->training_prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>ゴルフ歴</th>
              <td class="required">
                <?=$entities['CompanionInfo']->history?>
              </td>
            </tr>
            <tr>
              <th>ご職業</th>
              <td class="required">
                <?=$entities['CompanionInfo']->job?>
              </td>
            </tr>
            <tr>
              <th>設定料金</th>
              <td class="required">
                <?=$entities['CompanionInfo']->amount?>
              </td>
            </tr>
            <tr>
              <th>プレイ費</th>
              <td class="required">
                <?=$entities['CompanionInfo']->play_amount_kind_name?>
              </td>
            </tr>
            <tr>
              <th>ペアの方のメールアドレス</th>
              <td class="required">
                <?=$entities['CompanionInfo']->pair_emai?>
              </td>
            </tr>
          </tbody>
        </table>
        <?php if($entities['CompanionInfo']->amount != 0 || $entities['CompanionInfo']->play_amount_kind == '2') {?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">お振込先情報</h2>
        </div>
		<table class="table input-table mb50">
          <tbody style="border-bottom:0px">
          <tr>
            <th>金融機関名</th>
            <td class="required">
              <p class="control">
			    <?=$entities['CompanionInfo']->payment_bank?>
              </p>
            </td>
          </tr>
          <tr>
            <th>支店名</th>
            <td class="required">
              <p class="control">
			    <?=$entities['CompanionInfo']->payment_shop_name?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座種別</th>
            <td class="required">
              <p class="control">
			    <?=$entities['CompanionInfo']->payment_bank_kind_name?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座番号</th>
            <td class="required">
              <p class="control">
			    <?=$entities['CompanionInfo']->payment_no?>
              </p>
            </td>
          </tr>
          <tr>
            <th>口座名義</th>
            <td class="required">
              <p class="control">
			    <?=$entities['CompanionInfo']->payment_name?>
              </p>
            </td>
          </tr>
          </tbody>
        </table>
        <?php }?>
        <?php }?>
        <button type="submit" class="button">
          <span>変更する</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>

      </section>
    </div>
  </section>
</section>
