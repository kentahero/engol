<header class="hero header">
  <div class="hero-head">
    <div class="nav" id="nav">
      <div class="nav-left">
        <h1 class="logo-block">
          <a class="nav-item nav-link" href="/">
            <img src="/img/logo.png"><br>
          </a>
        </h1>
      </div>
      <div class="nav-right has-text-right" style="margin:5px">
        <?php if (isset($member)) {?>
          <span class="ic-char" style="margin-right:50px">ようこそ<?=$member->nickname?>さん</span>
          <button type="button" class="drawer-toggle drawer-hamburger" style="padding-top: 10px">
            <img src="/img/icon-menu.png"/>
            <!--
  			<span class="sr-only">toggle navigation</span>
  			<span class="drawer-hamburger-icon"></span>
  			-->
		  </button>
		  <!--
          <a class="nav-item nav-link" href="/member/index">
            <img src="/img/icon-mail.png" style="max-height: 30px"/>
          </a>
          -->
        <?php } else { ?>
        <a class="nav-item nav-link" href="/member/login">
          <i class="ci img-user-out"></i>
          <span class="ic-char">ログイン</span>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <nav class="drawer-nav" id="menu" style="width:200px">
    <div style="text-align:center;background:#d0f0e1">会員メニュー</div>
    <ul class="drawer-menu">
      <!-- ドロワーメニューの中身 -->
      <li><a href="/member/index">メールボックス</a></li>
      <li><a href="/profile/index/<?=$member->id?>">プロフィール確認</a></li>
      <li><a href="/member-edit/index">プロフィール変更</a></li>
      <li><a href="/member/logout">ログアウト</a></li>
      <li><a href="#">パスワード変更</a></li>
      <?php if($member->companion_flg == '1') {?>
      <li><a href="#">ゴルファー情報非公開</a></li>
      <?php }?>
      <li><a href="#">退会</a></li>
    </ul>
  </nav>
</header>
