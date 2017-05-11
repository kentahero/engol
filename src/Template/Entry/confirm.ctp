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
        <?php echo $this->Form->create($data,['type'=>'post','url'=>['controller'=>'Entry','action'=>'complete']]);?>
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
            <tr>
              <th>Eメール</th>
              <td class="required">
                <?=$data['email']?>
              </td>
            </tr>
            <tr>
              <th>メール種別</th>
              <td>
                <?=$data['email_kind_name']?>
              </td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td class="required">
                ●●●●●●●●●●●●
              </td>
            </tr>
            <tr>
              <th>姓</th>
              <td class="required">
                <?=$data['first_name']?>
              </td>
            </tr>
            <tr>
              <th>名</th>
              <td class="required">
                <?=$data['last_name']?>
              </td>
            </tr>
            <tr>
              <th>姓（カナ）</th>
              <td class="required">
                <?=$data['first_kana']?>
              </td>
            </tr>
            <tr>
              <th>名（カナ）</th>
              <td class="required">
                <?=$data['last_kana']?>
              </td>
            </tr>
            <tr>
              <th>ニックネーム</th>
              <td class="required">
                <?=$data['nickname']?>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td class="required">
                <?=$data['sex_name']?>
              </td>
            </tr>
            <tr>
              <th>
                生年月日
              </th>
              <td class="required">
                <p class="control bvc date">
                  <?=$data['birty_year']?>年<?=$data['birty_month']?>月<?=$data['birty_day']?>日
                </p>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <?=$data['postal']?>
              </td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td>
                <?=$data['prefecture_name']?>
              </td>
            </tr>
            <tr>
              <th>市区町村</th>
              <td>
                <?=$data['city_name']?>
              </td>
            </tr>
            <tr>
              <th>町名番地</th>
              <td>
                <?=$data['address1']?>
              </td>
            </tr>
            <tr>
              <th>建物名・部屋番号</th>
              <td>
                <?=$data['address2']?>
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>
                <?=$data['tel']?>
              </td>
            </tr>

            <tr>
              <th>
                希望日付1
              </th>
              <td class="required">
                <?=$data['offer_year_1']?>年<?=$data['offer_month_1']?>月<?=$data['offer_day_1']?>日
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td class="required">
                <?=$data['offer_year_2']?>年<?=$data['offer_month_2']?>月<?=$data['offer_day_2']?>日
              </td>
            </tr>


            <tr>
              <th>
                希望日付3
              </th>
              <td class="required">
                <?=$data['offer_year_3']?>年<?=$data['offer_month_3']?>月<?=$data['offer_day_3']?>日
              </td>
            </tr>


            <tr>
              <th>プレイ場所</th>
              <td>
                ゴルフ場, 練習場
              </td>
            </tr>
            <tr>
              <th>ゴルフ場地域</th>
              <td>
                大阪府
              </td>
            </tr>
            <tr>
              <th>ゴルフ場名</th>
              <td>
                茨木カントリークラブ
              </td>
            </tr>
            <tr>
              <th>練習場地域</th>
              <td>
                大阪府
              </td>
            </tr>
            <tr>
              <th>練習場名</th>
              <td>
                  茨木ゴルフ練習場
              </td>
            </tr>
            <tr>
              <th>お相手にメッセージ</th>
              <td>
                <?=nl2br($data['message'])?>
              </td>
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
