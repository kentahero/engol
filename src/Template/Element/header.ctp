<header class="hero header">
  <div class="hero-head">
    <div class="nav">
      <div class="nav-left">
        <h1 class="logo-block">
          <a class="nav-item nav-link" href="/">
            <img src="/img/engol_logo_white4k.png"><br>
          </a>
        </h1>
      </div>
      <div class="nav-right has-text-right" style="margin:5px">
        <?php if (isset($member)) {?>
          <span class="ic-char">ようこそ<?=$member->nickname?>さん</span>
        <a class="nav-item nav-link" href="/member/index">
          <img src="/img/icon-mail.png" style="width:30px"/>
        </a>
        <?php } else { ?>
        <a class="nav-item nav-link" href="/member/login">
          <i class="ci img-user-out"></i>
          <span class="ic-char">ログイン</span>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
</header>
