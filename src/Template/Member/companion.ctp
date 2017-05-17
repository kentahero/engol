<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="">トップ</a></li>
        <li class="strong"><a href="">メールボックス</a></li>
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
  </section>
  <section class="container">
    <div class="profile-area">
      <section class="profile-main-block">
        <div class="confirm-msg-area mb10">
          メールボックス
        </div>
        <table class="table input-table mb50">
          <tbody>
            <?php foreach($offers as $offer) {?>
            <tr>
              <?php if ($offer->status == 0) {?>
              <td>
              <p>■<a href="/member/detail?offer_id=<?=$offer->id?>"><?=$offer->offer_user->nickname?>さんからオファーされました</a></p>
              <p style="font-size:1px"><?=$offer->course_name?>にて<?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>希望<p>
              <p style="font-size:1px;text-align:right"><?=$offer->created->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?></p>
              </td>
              <?php } else if ($offer->status == 1) {?>
              <td>■<?=$offer->created?> <?=$offer->recieve_group->users[0]->nickname?>さんからのオファーを承諾しました<br/><?=$offer->course_name?>にて<?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>希望<p></td>
              <?php } else if ($offer->status == 2) {?>
              <td>■<?=$offer->created?> <?=$offer->recieve_group->users[0]->nickname?>さんからのオファーが成立しました<br/><?=$offer->course_name?>にて<?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>希望<p></td>
              <?php }?>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </section>
    </div>
  </section>
</section>
