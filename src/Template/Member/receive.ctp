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
      <div class="box">
        <div class="title-block is-clearfix">
          <span class="icon left">
            <i class="ci img-ball-search"></i>
          </span>
          <p class="is-pulled-left name"><span class="<?=$offer->offer_user->sex_class?>"><?=$this->Text->truncate($offer->offer_user->nickname,9)?></span></p>
          <!--<p class="is-pulled-right status">ログイン：本日</p>-->
        </div>
        <div class="pair-block">
          <div class="card">
              <div class="card-image">
                <figure class="image is-4by3">
                  <img src="/img/pic/nophoto.png" alt="Image">
                </figure>
              </div>
              <div class="user-attr <?=$offer->offer_user->sex_class?>">
                <p class="name"><?=$this->Text->truncate($offer->offer_user->nickname,11)?>さん</p>
                <p class="age"><?=$offer->offer_user->real_age?>歳(<?=$offer->offer_user->sex_name?>)</p>
                <p class="current-pref"><?=$offer->offer_user->prefecture->name?></p>
              </div>
          </div>
      </div>
    </div>
  </section>
  <section class="container">
    <div class="profile-area">
      <section class="profile-main-block">
        <div class="confirm-msg-area mb10">
          オファー内容を確認
        </div>
        <?php if(isset($error)) {?>
        <div class="error-msg-area mb10">
          希望日を選択して下さい
        </div>
        <?php }?>
        <div class="mb10">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title male bvc">オファー状態：<?=$offer->receive_title?></h2>
        </div>
        <?php if ($offer->status == Offer::STATUS_OFFER) {?>
        <?php echo $this->Form->create(null,['type'=>'post','url'=>['controller'=>'member','action'=>'accept']]);?>
        <?php } ?>
        <?=$this->Form->hidden('offer_id',['value'=>$offer->id])?>
        <table class="table input-table mb50">
          <tbody>
            <?php if ($offer->status == Offer::STATUS_OFFER || $offer->status == Offer::STATUS_REDUCE) {?>
            <tr>
              <th>
                希望日付1
              </th>
              <td>
                <?php if ($offer->date1) { echo $offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
                <input type="radio" name="offer_date" id="consent1" value="<?=$offer->date1->i18nFormat('YYYY-MM-dd', 'Asia/Tokyo')?>"/><label for="consent1">選択</label>
                <?php } ?>
              </td>
            </tr>

            <tr>
              <th>
                希望日付2
              </th>
              <td>
                <?php if ($offer->date2) { echo $offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
                <input type="radio" name="offer_date" id="consent2" value="<?=$offer->date2->i18nFormat('YYYY-MM-dd', 'Asia/Tokyo')?>"/><label for="consent2">選択</label>
                <?php }?>
              </td>
            </tr>
            <tr>
              <th>
                希望日付3
              </th>
              <td>
                <?php if ($offer->date3) { echo $offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>
                <input type="radio" name="offer_date" id="consent3" value="<?=$offer->date3->i18nFormat('YYYY-MM-dd', 'Asia/Tokyo')?>"/><label for="consent3">選択</label>
                <?php }?>
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
            <?php if($offer->course_kind  == '1') {?>
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
        <?php if ($offer->status == 0) {?>
        <button type="submit" class="button">
          <span>承諾する</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        <?php echo $this->Form->end()?>
        <br/>
        <a href="/member/reduce?offer_id=<?=$offer->id?>">
        <button type="submit" class="button">
          <span>拒否する</span>
          <span class="icon is-medium right">
              <i class="ci img-next"></i>
          </span>
        </button>
        </a>
        <?php } else if ($offer->status != Offer::STATUS_REDUCE && $offer->status != Offer::STATUS_CANCEL) {?>
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
