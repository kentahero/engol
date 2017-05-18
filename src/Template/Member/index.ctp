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
        <table class="input-table mb50 is-bordered" style="boerder:1px">
          <tbody>
            <?php if(count($offers) == 0) {?>
            <tr><td><p style="text-align:center;">メッセージがありません</p></td></tr>
            <?php } else {?>
            <?php foreach($offers as $offer) {?>
            <tr>
              <?php if ($offer->offer_user_id == $member->id) {?>
              <td>
              <p style="font-size:3px">■<a href="/member/detail?offer_id=<?=$offer->id?>"><?=$offer->offer_title?></a></p>
              <p style="font-size:1.5px">お相手：<?=$offer->recieve_group->users[0]->nickname?><p>
              <p style="font-size:1.5px">場所：<?=$offer->course_name?>　日時：<?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>希望<p>
              <p style="font-size:1px;text-align:right"><?=$offer->created->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?></p>
              </td>
              <?php } else {?>
              <td>
              <p style="font-size:3px">■<a href="/member/detail?offer_id=<?=$offer->id?>"><?=$offer->recieve_title?></a></p>
              <p style="font-size:1.5px">お相手：<?=$offer->offer_user->nickname?><p>
              <p style="font-size:1.5px">場所：<?=$offer->course_name?>　日時：<?=$offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>希望<p>
              <p style="font-size:1px;text-align:right"><?=$offer->created->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?></p>
              </td>
              <?php }?>
            </tr>
            <?php }?>
            <?php }?>
          </tbody>
        </table>
      </section>
    </div>
  </section>
</section>
