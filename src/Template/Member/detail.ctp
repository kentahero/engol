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
        <table class="table input-table mb20">
          <tbody>
            <?php if ($offer->status == Offer::STATUS_OFFER || $offer->status == Offer::STATUS_REDUCE) {?>
            <tr>
              <th>
                希望日付1
              </th>
              <td>
                <?php if ($offer->date1)echo $offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <tr>
              <th>
                希望日付2
              </th>
              <td>
                <?php if ($offer->date2)echo $offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <tr>
              <th>
                希望日付3
              </th>
              <td>
                <?php if ($offer->date3)echo $offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <?php } else {?>
            <tr>
              <th>
                決定プレイ日付
              </th>
              <td>
                <?php if ($offer->play_date) echo $offer->play_date->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
              </td>
            </tr>
            <?php }?>
            <tr>
              <th>プレイ場所</th>
              <td>
                <?=$offer->course_kind_name?>
              </td>
            </tr>
            <?php if($offer->course_kind == '1') {?>
            <tr>
              <th>ゴルフ場地域</th>
              <td>
                <?=$offer->course_prefecture->name?>
              </td>
            </tr>
            <tr>
              <th>ゴルフ場名</th>
              <td>
                <?=$offer->course_name?>
              </td>
            </tr>
            <?php } else {?>
            <tr>
              <th>練習場地域</th>
              <td>
                <?=$offer->training_prefecture->name?>
              </td>
            </tr>
            <tr>
              <th>練習場名</th>
              <td>
                 <?=$offer->training_name?>
              </td>
            </tr>
            <?php }?>
            <tr>
              <th>メッセージ</th>
              <td>
                <?=nl2br($offer->message)?>
              </td>
          </tbody>
        </table>
        <?php if ($offer->status == Offer::STATUS_ACCEPT) {?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">お支払料金 ※料金をお支払頂くまでご成約となりません</h2>
        </div>
        <table class="table is-bordered">
          <tr>
            <th>サイト利用料金</th>
            <td  style="text-align:right;padding-right:10px;"><?=number_format($amount['site_amount'])?>円</td>
          </tr>
          <tr style="background:#00000">
            <th>合計</th>
            <td  style="text-align:right;padding-right:10px;"><?=number_format($amount['total'])?>円</td>
          </tr>
        </table>
        <form action="https://credit.j-payment.co.jp/gateway/payform.aspx" method="POST">
          <input type="hidden" name="aid" value="114442"/>
          <input type="hidden" name="pt" value="1"/>
          <input type="hidden" name="am" value="<?=$amount['site_amount']?>"/>
          <input type="hidden" name="tx" value="0"/>
          <input type="hidden" name="sf" value="0"/>
          <input type="hidden" name="jb" value="CAPTURE"/>
          <input type="hidden" name="cod" value="<?=$offer->id?>"/>
          <button type="submit" class="button">
            <span>クレジットカードでのお支払</span>
            <span class="icon is-medium right">
              <i class="ci img-next"></i>
            </span>
          </button>
        </form>
        <br/>
        <a href="javascript:void(0)" onClick="$('#bank_info').show()">
        <button type="button" class="button">
          <span>銀行振込でのお支払</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        </a>
        <div id="bank_info" style="display:none">
          <p>以下の口座にお振込みをお願いいたします。お振込み確認後にメールにてご成約のご連絡を差し上げます。</p>
          <table class="table is-bordered">
            <tr>
              <th>金融機関名</th>
              <td  style="text-align:right;padding-right:10px;">りそな銀行 (0010)</td>
            </tr>
            <tr style="background:#00000">
              <th>支店名</th>
              <td  style="text-align:right;padding-right:10px;">天六支店 (112)</td>
            </tr>
            <tr style="background:#00000">
              <th>口座種別</th>
              <td  style="text-align:right;padding-right:10px;">普通</td>
            </tr>
            <tr style="background:#00000">
              <th>口座番号</th>
              <td  style="text-align:right;padding-right:10px;">329550</td>
            </tr>
            <tr style="background:#00000">
              <th>口座名義</th>
              <td  style="text-align:right;padding-right:10px;">株式会社ティーエイチツー</td>
            </tr>
            <tr style="background:#00000">
              <th>口座名義(カナ)</th>
              <td  style="text-align:right;padding-right:10px;">カ）テイーエイチツー</td>
            </tr>
          </table>
        </div>
       <?php } else if ($offer->status == Offer::STATUS_PAID) {?>
       <div class="mb10">
          <h2 class="profile-title male bvc">お相手の人数分も含めてゴルフ場をご自身でご予約下さい。</h2>
       </div>
       <script language="javascript" src="//ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=3342893&pid=885108466"></script>
       <noscript>
         <a href="//ck.jp.ap.valuecommerce.com/servlet/referral?sid=3342893&pid=885108466" target="_blank" rel="nofollow">
           <img src="//ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=3342893&pid=885108466" border="0">
         </a>
       </noscript>
       <?php } ?>
       <br/>
       <br/>
       <?php if ($offer->status != Offer::STATUS_REDUCE && $offer->status != Offer::STATUS_CANCEL) {?>
        <button type="submit" class="button">
          <span>このオファーをキャンセル</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        <?php }?>
      </section>
    </div>
  </section>
</section>
