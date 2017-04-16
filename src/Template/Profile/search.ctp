<section class="main-content">
  <section class="search-visual">
  </section>
  <div class="bg-green">
    <section class="container search-area">
      <div class="mb20">
        <ul class="brcb">
          <li class="strong"><a href="">トップ</a></li>
          <li><a href="">プロフィール検索</a></li>
        </ul>
        <!--
        <a class="bvc back-btn-link" href="./index.html">
          <img class="back-btn bvc" src="/img/icon-back.png">
          <span class="back-btn-name">戻る</span>
        </a>
        -->
      </div>
      <!-- <h2 class="title-content has-text-centered mb20">お相手プロフィール検索</h2> -->
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

        <section class="search-clear-block">
          <a class="has-text-right bvc" href="#">
            <span class="bvc">検索条件をクリアする</span>
            <i class="ci img-clear"></i>
          </a>
        </section>
      </div>
    </section>
  </div>
  <section class="pagination-area">
    <div class="bvc current-block">
      <p class="current-page">9,999名／1～10名表示</p>
    </div>
    <i class="ci img-golf-cup-search"></i>
    <div class="bvc pagination-block">
      <i class="ci img-search-left-gray"></i>
      <ul>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">8</a></li>
        <li><a href="#">9</a></li>
        <li><a href="#">10</a></li>
      </ul>
      <i class="ci img-search-right-gray"></i>
    </div>
  </section>
  <section class="search-list-area container">
    <div class="columns">
      <div class="column is-half">
        <div class="box">
          <div class="title-block is-clearfix">
            <span class="icon left">
              <i class="ci img-ball-search"></i>
            </span>
            <p class="is-pulled-left name"><span class="male">Hideki</span> & <span class="female">Hiroshi</span> ペア</p>
            <p class="is-pulled-right status">ログイン：本日</p>
          </div>
          <div class="pair-block">
            <div class="card male">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr male">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
            <span class="icon pair-cross">
              <i class="ci img-cross"></i>
            </span>
            <div class="card female">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr female">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(女)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
          </div>
          <a href="#" class="button">
            <span>このペアで予約する</span>
              <span class="icon is-medium right">
                <i class="ci img-next"></i>
              </span>
          </a>
        </div>
      </div>
      <div class="column is-half">
        <div class="box">
          <div class="title-block is-clearfix">
            <span class="icon left">
              <i class="ci img-ball-search"></i>
            </span>
            <p class="is-pulled-left name"><span class="male">Hideki</span> & <span class="female">Hiroshi</span> ペア</p>
            <p class="is-pulled-right status">ログイン：本日</p>
          </div>
          <div class="pair-block">
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr male">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
            <span class="icon pair-cross">
              <i class="ci img-cross"></i>
            </span>
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr female">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
          </div>
          <a href="#" class="button">
            <span>このペアで予約する</span>
              <span class="icon is-medium right">
                <i class="ci img-next"></i>
              </span>
          </a>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half">
        <div class="box">
          <div class="title-block is-clearfix">
            <span class="icon left">
              <i class="ci img-ball-search"></i>
            </span>
            <p class="is-pulled-left name"><span class="male">Hideki</span> & <span class="female">Hiroshi</span> ペア</p>
            <p class="is-pulled-right status">ログイン：本日</p>
          </div>
          <div class="pair-block">
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr male">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
            <span class="icon pair-cross">
              <i class="ci img-cross"></i>
            </span>
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr female">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
          </div>
          <a href="#" class="button">
            <span>このペアで予約する</span>
              <span class="icon is-medium right">
                <i class="ci img-next"></i>
              </span>
          </a>
        </div>
      </div>
      <div class="column is-half">
        <div class="box">
          <div class="title-block is-clearfix">
            <span class="icon left">
              <i class="ci img-ball-search"></i>
            </span>
            <p class="is-pulled-left name"><span class="male">Hideki</span> & <span class="female">Hiroshi</span> ペア</p>
            <p class="is-pulled-right status">ログイン：本日</p>
          </div>
          <div class="pair-block">
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr male">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
            <span class="icon pair-cross">
              <i class="ci img-cross"></i>
            </span>
            <div class="card">
              <a class="card-link" href="/profile/">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <img src="/img/pic/sample03.jpg" alt="Image">
                  </figure>
                </div>
                <div class="user-attr female">
                  <p class="name">Hidekiさん</p>
                  <p class="sex">(男)</p>
                  <p class="age">32歳</p>
                  <p class="current-pref">大阪府</p>
                </div>
              </a>
            </div>
          </div>
          <a href="#" class="button">
            <span>このペアで予約する</span>
            <span class="icon is-medium right">
                <i class="ci img-next"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
  </section>
  <section class="pagination-area mb20">
    <div class="bvc current-block">
      <p class="current-page">9,999名／1～10名表示</p>
    </div>
    <i class="ci img-golf-cup-search"></i>
    <div class="bvc pagination-block">
      <i class="ci img-search-left-gray"></i>
      <ul>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">8</a></li>
        <li><a href="#">9</a></li>
        <li><a href="#">10</a></li>
      </ul>
      <i class="ci img-search-right-gray"></i>
    </div>
  </section>
</section>