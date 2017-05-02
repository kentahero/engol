 <?= $this->Html->script('detail_app', array('inline' => false)); ?>
<section class="main-content detail-page">
  <section class="profile-pic-area">
    <section class="bg-green profile-title-block">
      <ul class="brcb">
        <li class="strong"><a href="">トップ</a></li>
        <li class="strong"><a href="">プロフィール検索</a></li>
        <li><a href=""><?=$user->nickname?>さん</a></li>
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
    <div class="slick-slider-detail mb40">
      <?php if($user->companion_info->image != 0) {?>
      <?php for($i=1;$i<=$user->companion_info->image;$i++) {?>
      <div class="card mrl5">
        <div class="card-image">
          <figure class="image is-square">
            <img src="/img/pic/pic_<?=$user->id?>_<?=$i?>.jpg" alt="Image">
          </figure>
        </div>
      </div>
      <?php }?>
      <?php }else{?>
      <div class="card mrl5">
        <div class="card-image">
          <figure class="image is-square">
            <img src="/img/pic/nophoto.png" alt="Image">
          </figure>
        </div>
      </div>
      <?php }?>
    </div>
    <section class="basic-info-block mb20 <?=$user->sex_class?>">
      <div class="is-clearfix">
        <ul class="is-pulled-left basic-info <?=$user->sex_class?>">
          <li class="name"><?=$user->nickname?>さん</li>
          <li class="age"><?=$user->display_age?>歳(<?=$user->sex_name?>)</li>
          <li class="current-pref"><?=$user->prefecture->name?></li>
        </ul>
        <div class="status bvc is-pulled-right">ログイン：本日</div>
      </div>
    </section>
  </section>
  <section class="container">
    <div class="profile-area">
      <section class="profile-main-block">
        <div class="mb20">
          <span class="">
            <i class="ci img-flag-<?=$user->sex_class?>"></i>
          </span>
          <h2 class="profile-title <?=$user->sex_class?> bvc">自己PR</h2>
          <p class="summary">
            <?=nl2br($user->companion_info->pr)?>
          </p>
        </div>
        <div class="mb20">
          <span class="">
            <i class="ci img-ball"></i>
          </span>
          <h2 class="profile-title <?=$user->sex_class?> bvc">プレイヤー情報</h2>
        </div>
        <table class="table <?=$user->sex_class?>">
          <tbody>
            <tr>
              <th>平均スコア</th>
              <td><?=$user->companion_info->average_score?></td>
            </tr>
            <tr>
              <th>ラウンド(曜日)</th>
              <td><?=$user->companion_info->round_week?></td>
            </tr>
            <tr>
              <th>練習場(曜日)</th>
              <td><?=$user->companion_info->training_week?></td>
            </tr>
            <tr>
              <th>ゴルフ場エリア</th>
              <td>大阪府 枚方市</td>
            </tr>
            <tr>
              <th>ゴルフ練習場エリア</th>
              <td>大阪府 茨木市</td>
            </tr>
            <tr>
              <th>ゴルフ歴</th>
              <td><?=$user->companion_info->history?></td>
            </tr>
            <tr>
              <th>職業</th>
              <td><?=$user->companion_info->job?></td>
            </tr>
            <tr>
              <th>設定料金</th>
              <td><?=number_format($user->companion_info->amount)?>円</td>
            </tr>
            <?php if ($user->pair) {?>
            <tr>
              <th>ペアリング</th>
              <td>
                <!-- <?=$user->nickname?> & <?=$user->pair->nickname?> -->
                <div class="container">
                  <div class="card <?=$user->pair->sex_class?>">
                    <a class="card-link" href="/profile/index/<?=$user->pair->id?>">
                      <div class="card-image">
                        <figure class="image is-4by3">
                          <?php if($user->pair->companion_info->image != 0) {?>
                          <img src="/img/pic/pic_<?=$user->pair->id?>_1.jpg" alt="Image">
                          <?php }else{?>
                          <img src="/img/pic/nophoto.png" alt="Image">
                          <?php }?>
                        </figure>
                      </div>
                      <div class="user-attr <?=$user->pair->sex_class?>">
                        <p class="name"><?=$this->Text->truncate($user->pair->nickname,12)?>さん</p>
                        <p class="age"><?=$user->pair->display_age?>歳(<?=$user->pair->sex_name?>)</p>
                        <p class="current-pref"><?=$user->pair->prefecture->name?></p>
                      </div>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </section>
    </div>
  </section>
</section>
<p class="reserve-btn">
  <a href="/entry/?group_id=<?=$user->group_id?>" class="button">
    <?php if($user->pair) {?>
    <span>このペアにオファーする</span>
    <?php } else {?>
    <span>この人にオファーする</span>
    <?php }?>
    <span class="icon is-medium right">
        <i class="ci img-next"></i>
    </span>
  </a>
</p>

