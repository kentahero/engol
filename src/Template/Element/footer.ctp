  <?php if (!isset($member) || $member['companion_flg'] != '1') {?>
  <a href="/golfer-entry/index">
  <section class="staff-area">
    <i class="ci img-golf-player"></i>
    ゴルファーとして登録する
    <i class="ci img-golf-player"></i>
  </section>
  </a>
  <?php } ?>
  <section class="other-area">
    <ul>
      <li><a href="/pages/use">ご利用の流れ</a></li>
      <li><a href="/pages/amount">料金について</a></li>
      <?php if (!isset($member)) { ?>
      <li><a href="/member/login">ログイン</a></li>
      <?php } else { ?>
      <li><a href="/member/logout">ログアウト</a></li>
      <?php } ?>
    </ul>
    <ul>
      <li><a href="/pages/terms">利用規約</a></li>
      <li><a href="/pages/company">運営者情報</a></li>
      <li><a href="/pages/privacy">個人情報保護方針</a></li>
      <li><a href="/pages/disclaimer">免責事項</a></li>
      <li><a href="/pages/transaction">特定商取引法に基づく表記</a></li>
    </ul>
  </section>

<footer class="footer is-main">
  <div class="has-text-centered">
    <span >Copylight 2017 TH2 co.ltd., All right Reserved.</span>
  </div>
</footer>
<p class="pagetop"><a href="#wrap"><i class="fa fa-arrow-up"></i></a></p>

