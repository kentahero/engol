<?php $this->assign('title','ゴルフのお相手を探すならエンゴル');?>
<?php $this->assign('description','エンゴルはゴルフのお相手を気軽に探せるサイトです。ゴルフ場でラウンドしたいけど相手が居なくて困っている方。複数人で楽しくプレイしたい方。教えてもらう相手を探している方はすぐにお相手が見つかります');?>
<section class="main-content">
  <section class="main-visual">
    <h1 class="top-keyword">
      <p>もっと<span>ゴルフをエンジョイ</span>しよう！</p>
      <p>ゴルフから始まる<span>新しい出会い！</span></p>
    </h1>
    <div class="conv-button-block">
      <a href="/profile/search" class="conv-button">
        <img src="./img/btn_conversion.png" class="img1" alt="検索してからオファーする" />
      </a>
    </div>
  </section>
  <section class="count-area">
    <div class="bvc count-title-block">
      <p class="main-title">累計ラウンド数</p>
      <p class="main-title-english">Total Rounds</p>
    </div>
    <div class="bvc round-count-block">
      <i class="ci img-golf-cup"></i>
      <span class="ronund-count"><?=number_format($count)?></span>
    </div>
  </section>
  <section class="sub-visual">
  </section>
  <section class="sub-visual-description">
  </section>
  <a href="/golfer-entry/index">
  <section class="staff-area">
    <i class="ci img-golf-player"></i>
    ゴルファーとして登録する
    <i class="ci img-golf-player"></i>
  </section>
  </a>
  <div class="bg-green">
    <section class="container pb20">
      <h2 class="title-content has-text-centered"><b class="strong-color-red">3 Step</b>で<b>オファー</b>ができる！</h2>
      <p class="sub-title has-text-centered strong-color-red">Reserve in 3 Steps</p>
      <div class="reserve-description">
        <div class="float-inner">
          <dl>
            <dt class="bvc">
              <h5 class="reserve-baloon mb10">Step1</h5>
              <span class="bvc">性別・年齢・目的から</span>
              <span class="bvc">お相手を<b class="strong-color-red">選ぶ</b></span>
            </dt>
            <dd class="bvc">
              <img src="./img/reserve_step_01.png" alt="" />
            </dd>
          </dl>
          <dl>
            <dt class="bvc">
              <h5 class="reserve-baloon mb10">Step2</h5>
              <span class="bvc">自分が行ける範囲から</span>
              <span class="bvc">地域を<b class="strong-color-red">選ぶ</b></span>
            </dt>
            <dd class="bvc">
              <img src="./img/reserve_step_02.png" alt="" />
            </dd>
          </dl>
          <dl>
            <dt class="bvc">
              <h5 class="reserve-baloon mb10">Step3</h5>
              <span class="bvc">お相手と地域が決まったら</span>
              <span class="bvc">申込内容を<b class="strong-color-red">入力</b></span>
            </dt>
            <dd class="bvc">
              <img src="./img/reserve_step_03.png" alt="" />
            </dd>
          </dl>
        </div>
      </div>
    </section>
  </div>
  <section class="container">
    <div class="ptb10">
      <div class="conv-button-block">
        <a href="/profile/search" class="conv-button mb20">
          <img src="/img/btn_conversion.png" alt="検索してからオファーする" />
        </a>
      </div>
    </div>
    <h2 class="title-content has-text-centered strong-color-green"><img class="reason-logo" src="./img/engol_logo2.png" />が<b class="reason-title-text strong-color-red">選ばれる理由</b></h2>
    <p class="sub-title has-text-centered strong-color-red">Reason for choosing</p>
    <div class="select-description">
      <div class="float-inner">
        <dl>
          <dt class="bvc description has-text-left">
            １人でもゴルフを始める事ができ、
            まずは練習場から仲間をつくり
            自信が出来たらコースデビューも！
          </dt>
          <dd class="bvc">
            <img src="./img/reason_step_01.png" alt="" />
          </dd>
        </dl>
        <dl>
          <dt class="bvc description has-text-left">
            ゴルフを楽しみながら仲間を増やし
            新たな出会いができます。
          </dt>
          <dd class="bvc">
            <img src="./img/reason_step_02.png" alt="" />
          </dd>
        </dl>
        <dl>
          <dt class="bvc description has-text-left">
            誰でも気軽にゴルフを始めることができ
            もっと身近にゴルフを感じてもらえるよう
            当社は色々な取り組みをしています。
          </dt>
          <dd class="bvc">
            <img src="./img/reason_step_03.png" alt="" />
          </dd>
        </dl>
      </div>
    </div>
  </section>
  <div class="bg-green">
    <section class="container search-area">
      <h2 class="search-title-content has-text-centered">まずは<b class="strong-color-red">簡単</b>な<b class="strong-color-red">検索</b>から</h2>
      <p class="sub-title has-text-centered strong-color-red mb20">Easy search</p>
      <!-- <p class="section-description">〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇</p> -->
      <?php echo $this->Form->create(null,['valueSources'=>'query','type'=>'get','url' => ['controller' => 'Profile', 'action' => 'search']]) ?>
      <div class="box mb20">
        <p class="search-title mb10">
          <span class="icon left">
            <i class="ci img-ball"></i>
          </span>
          お相手を選ぶ
        </p>
        <section class="container is-clearfix" style="padding:5px">
          <span class="select mb10 is-pulled-left">
            <select class="" name="age">
              <option value='' disabled selected style='display:none;'>年齢を選択</option>
              <option value="20">20歳～24歳</option>
              <option value="25">25歳～29歳</option>
              <option value="30">30歳～34歳</option>
              <option value="35">35歳～39歳</option>
              <option value="40">40歳～</option>
            </select>
          </span>
          <span class="select is-pulled-right">
            <?php echo $this->Form->select('pref',$prefs,['empty'=>'地域を選択'])?>
          </span>
        </section>

        <section class="container" style="padding:0px">
          <div class="checkbox-block">
            <input type="checkbox" id="male" name="sex" value="1"/><label for="male">男性</label>
            <input type="checkbox" id="female" name="sex" value="2"/><label for="female">女性</label>
          </div>
        </section>

        <section class="container">
          <button class="button">
            <span>この条件で検索する</span>
            <span class="icon is-medium right">
              <i class="ci img-search"></i>
            </span>
          </button>
        </section>
      </div>
      <?=$this->Form->end()?>
<!--       <p class="section-description">〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇</p>
      <div class="box">
        <p class="search-title mb10">
          <span class="icon left">
            <i class="ci img-ball"></i>
          </span>
          目的で選ぶ
        </p>
        <a href="#" class="button mb20">
          <span>誰かと一緒にプレイしたい</span>
          <span class="icon is-medium right">
            <i class="ci img-search"></i>
          </span>
        </a>
        <a href="#" class="button mb20">
          <span>上達したい</span>
          <span class="icon is-medium right">
            <i class="ci img-search"></i>
          </span>
        </a>
        <a href="#" class="button">
          <span>とりあえずプレイしたい</span>
          <span class="icon is-medium right">
            <i class="ci img-search"></i>
          </span>
        </a>
      </div>
 -->
     </section>
  </div>
  <section class="container">
    <h2 class="title-content has-text-centered">人気の<b class="strong-color-red">お相手</b>を<b class="strong-color-red">チェック</b></h2>
    <p class="sub-title has-text-centered strong-color-red">Check your partner</p>
    <div class="slick-slider mb40">
      <?php foreach($recommend as $user) {?>
      <div class="card mrl5">
        <a class="card-link" href="/profile/index/<?=$user->id?>">
          <div class="card-image">
            <figure class="image is-square">
              <?php if ($user->companion_info->image != 0) {?>
              <img src="/img/pic/pic_<?=$user->id?>_1.jpg" alt="Image">
              <?php } else { ?>
              <img src="/img/pic/nophoto.png" alt="Image">
              <?php }?>
            </figure>
          </div>
          <div class="user-attr">
            <p class="age"><?=$user->display_age?>歳</p>
            <p class="job"><?=$user->companion_info->job?></p>
            <p class="score">スコア <?=$user->companion_info->average_score?></p>
          </div>
        </a>
      </div>
      <?php }?>
    </div>

    <a href="#" class="button mb20">
      <span>お相手をもっと探す</span>
        <span class="icon is-medium right">
          <i class="ci img-search"></i>
        </span>
    </a>
    <div class="conv-button-block">
      <a href="/profile/search" class="conv-button">
        <img src="/img/btn_conversion.png" class="img1" alt="検索してからオファーする" />
      </a>
    </div>
  </section>
</section>