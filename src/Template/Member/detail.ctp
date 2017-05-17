<?php
use App\Model\Entity\Offer;
?>

<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="/">トップ</a></li>
        <li class="strong"><a href="/member">メールボックス</a></li>
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
        <div class="confirm-msg-area mb10">
          オファー内容を確認
        </div>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">オファー状態：<?=$offer->offer_title?></h2>
        </div>
        <table class="table input-table mb50">
          <tbody>
            <tr>
              <th>
                希望日付1
              </th>
              <td class="required">
                <?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td class="required">
                <?=$offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <tr>
              <th>
                希望日付3
              </th>
              <td class="required">
                <?=$offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
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
                <?=$offer->course_prefecture_name?>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場名</th>
              <td>
                <?=$offer->course_name?>
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
              <th>メッセージ</th>
              <td>
                <?=nl2br($offer->message)?>
              </td>
          </tbody>
        </table>
        <?php if ($offer->status == Offer::STATUS_ACCEPT) {?>
        <p>お支払料金</p>
        <table class="table is-bordered">
          <tr>
            <th>お相手のプレイ料金</th>
            <td style="text-align:right;padding-right:10px;"><?=number_format((15000*count($group->users)))?>円</td>
          </tr>
          <tr>
            <th>お相手の設定料金</th>
            <td  style="text-align:right;padding-right:10px;"><?=number_format($group->users[0]->companion_info->amount)?>円</td>
          </tr>
          <tr>
            <th>サイト利用料金</th>
            <td  style="text-align:right;padding-right:10px;"><?=number_format((5000*count($group->users)))?>円</td>
          </tr>
          <tr style="background:#00000">
            <th>合計</th>
            <td  style="text-align:right;padding-right:10px;">50,000円</td>
          </tr>
        </table>
        <a href="/member/pay">
        <button type="submit" class="button">
          <span>料金のお支払</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        </a>
        <p style="text-align:center">料金をお支払頂くまでご成約となりません</p>
        <?php } else {?>
        <button type="submit" class="button">
          <span>キャンセル</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        <?php }?>
      </section>
    </div>
  </section>
</section>