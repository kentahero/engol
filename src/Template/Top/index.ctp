<section class="main-content">
  <section class="main-visual">
    <h1 class="top-keyword">
      <p>もっと<span>ゴルフをエンジョイ</span>しよう！</p>
      <p>ゴルフから始まる<span>新しい出会い！</span></p>
    </h1>
    <div class="conv-button-block">
      <a href="/profile/search" class="conv-button">
        <img src="./img/btn_conversion.png" class="img1" alt="検索してから予約する" />
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
      <span class="ronund-count">9,999,999</span>
    </div>
  </section>
  <section class="sub-visual">
  </section>
  <section class="sub-visual-description">
  </section>
  <div class="bg-green">
    <section class="container pb20">
      <h2 class="title-content has-text-centered"><b class="strong-color-red">3 Step</b>で<b>予約</b>ができる！</h2>
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
          <img src="/img/btn_conversion.png" alt="検索してから予約する" />
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
      <div class="box mb20">
        <p class="search-title mb10">
          <span class="icon left">
            <i class="ci img-ball"></i>
          </span>
          お相手を選ぶ
        </p>

        <section class="container is-clearfix">
          <span class="select mb10 is-pulled-left">
            <select class="">
              <option value='' disabled selected style='display:none;'>年齢</option>
              <option value="">20歳～25歳</option>
              <option value="">26歳～30歳</option>
              <option value="">30歳～35歳</option>
              <option value="">36歳～40歳</option>
              <option value="">41歳～</option>
            </select>
          </span>
          <span class="select is-pulled-right">
            <select class="">
              <option value='' disabled selected style='display:none;'>地域</option>
              <?php foreach($prefs as $pref) {?>
              <option value="<?=$pref->cd?>"><?=$pref->name?></option>
              <?php } ?>
            </select>
          </span>
        </section>

        <section class="container">
          <div class="checkbox-block">
            <input type="checkbox" id="male"/><label for="male">男性</label>
            <input type="checkbox" id="female"/><label for="female">女性</label>
          </div>
        </section>

        <section class="container">
          <button class="button">
            <span>この条件で予約する</span>
            <span class="icon is-medium right">
              <i class="ci img-search"></i>
            </span>
          </button>
        </section>
      </div>
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
      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample01.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>

      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample02.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>

      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample03.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>

      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample04.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>

      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample05.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>

      <div class="card mrl5">
        <a class="card-link" href="/profile/">
          <div class="card-image">
            <figure class="image is-square">
              <img src="./img/pic/sample06.jpg" alt="Image">
            </figure>
          </div>
          <div class="user-attr">
            <p class="age">38歳</p>
            <p class="job">タレント</p>
            <p class="score">スコア 90</p>
          </div>
        </a>
      </div>
    </div>

    <a href="#" class="button mb20">
      <span>お相手をもっと探す</span>
        <span class="icon is-medium right">
          <i class="ci img-search"></i>
        </span>
    </a>
    <div class="conv-button-block">
      <a href="/profile/search" class="conv-button">
        <img src="/img/btn_conversion.png" class="img1" alt="検索してから予約する" />
      </a>
    </div>
  </section>
</section>