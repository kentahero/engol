<?php $this->assign('title','登録ゴルファーの一覧')?>
<?php $this->assign('description','エンゴルはゴルフのお相手を気軽に探せるサイトです。ゴルフ場でラウンドしたいけど相手が居なくて困っている方。複数人で楽しくプレイしたい方。教えてもらう相手を探している方はすぐにお相手が見つかります');?>
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
        <!--<form action="/profile/search" method="GET">-->
        <?php echo $this->Form->create(null,['valueSources'=>'query','type'=>'get']) ?>
        <p class="search-title mb10">
          <span class="icon left">
            <i class="ci img-ball"></i>
          </span>
          お相手の条件を入力
        </p>
        <section class="container is-clearfix" style="padding:5px">
          <span class="select mb10 is-pulled-left">
            <?php echo $this->Form->select('age',
            	[
            		['value'=>'20','text'=>'20歳～24歳'],
            		['value'=>'25','text'=>'25歳～29歳'],
            		['value'=>'30','text'=>'30歳～34歳'],
            		['value'=>'35','text'=>'35歳～39歳'],
            		['value'=>'40','text'=>'40歳～'],
            	],
            	['empty'=>'年齢を選択']
            );?>
          </span>
          <span class="select is-pulled-right">
            <?php echo $this->Form->select('pref',$prefs,['empty'=>'地域を選択'])?>
          </span>
        </section>

        <section class="container" style="padding:0px">
          <div class="checkbox-block">
            <input type="checkbox" id="male" value="1" name="sex"/><label for="male">男性</label>
            <input type="checkbox" id="female" value="2" name="sex"/><label for="female">女性</label>
          </div>
        </section>

        <section class="container">
          <button class="button" type="submit">
            <span>この条件で検索する</span>
            <span class="icon is-medium right">
              <i class="ci img-search"></i>
            </span>
          </button>
        </section>

        <section class="search-clear-block">
          <a class="has-text-right bvc" href="javascript:document.forms[0].reset();">
            <span class="bvc">検索条件をクリアする</span>
            <i class="ci img-clear"></i>
          </a>
        </section>
        <?=$this->Form->end()?>
      </div>
    </section>
  </div>
  <section class="pagination-area">
    <div class="bvc current-block">
      <p class="current-page"><?php echo $this->Paginator->counter('{{count}}ペア中／{{start}}～{{end}}表示');?></p>
    </div>
    <i class="ci img-golf-cup-search"></i>
    <div class="bvc pagination-block">
      <?php echo $this->Paginator->prev();?>
      <ul>
        <?php echo $this->Paginator->numbers(['tag'=>'li']);?>
      </ul>
      <?php echo $this->Paginator->next();?>
    </div>
  </section>
  <section class="search-list-area container">
      <?php
        if (count($groups) == 0) {
      ?>
　　　<div>お探しの条件ではお相手は見つかりませんでした</div>
      <?php
        }
      ?>
      <?php
        $i=0;
        foreach($groups as $group) {
          //グループのループ
          if (count($group->users) > 2) {
            //現在はペア表示のみ対応
            continue;
          }
          if ($i%2==0||$i==0) {
          	echo('<div class="columns">');
          }
      ?>
      <div class="column is-half">
        <div class="box">
          <div class="title-block is-clearfix">
            <span class="icon left">
              <i class="ci img-ball-search"></i>
            </span>
            <?php if (count($group->users) == 2) {?>
            <p class="is-pulled-left name" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><span class="male"><?=$group->users[0]->nickname?></span> & <span class="female"><?=$group->users[1]->nickname?></span> ペア</p>
            <?php } else {?>
            <p class="is-pulled-left name" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><span class="male"><?=$group->users[0]->nickname?></span></p>
            <?php }?>
            <!-- <p class="is-pulled-right status">ログイン：本日</p> -->
          </div>
          <div class="pair-block">
            <?php
              $j=0;
              foreach($group->users as $user) {
                //プレイヤーのループ
            ?>
            <div class="card">
              <a class="card-link" href="/profile/index/<?=$user->id?>">
                <div class="card-image">
                  <figure class="image is-4by3">
                    <?php if($user->companion_info->image != 0) {?>
                    <img src="/img/pic/<?=$user->companion_info['image_file1']?>" alt="Image">
                    <?php }else{?>
                    <img src="/img/pic/nophoto.png" alt="Image">
                    <?php }?>
                  </figure>
                </div>
                <div class="user-attr <?=$user->sex_class?>">
                  <p class="name"><?=$this->Text->truncate($user->nickname,11)?></p>
                  <p class="age"><?=$user->display_age?>歳(<?=$user->sex_name?>)</p>
                  <p class="current-pref"><?=$user->prefecture->name?></p>
                </div>
              </a>
            </div>
            <?php if ($j == 0 && count($group->users) >= 2) {?>
            <span class="icon pair-cross">
              <i class="ci img-cross"></i>
            </span>
            <?php
                }
                $j++;
              } //user loop end
            ?>
          </div>
          <a href="/entry/index?group_id=<?=$group->id?>" class="button">
            <?php if (count($group->users) == 2) {?>
            <span>このペアにオファーする</span>
            <?php } else { ?>
            <span>この人にオファーする</span>
            <?php }?>
            <span class="icon is-medium right">
                <i class="ci img-next"></i>
            </span>
          </a>
        </div>
      </div>
      <?php if($i%2!=0) {?>
      </div>
      <?php } //4つずつのdivタグ挿入?>
      <?php  $i++; } //group loop end?>
  </section>
  <section class="pagination-area mb20">
    <div class="bvc current-block">
      <p class="current-page"><?php echo $this->Paginator->counter('{{count}}ペア中／{{start}}～{{end}}表示');?></p>
    </div>
    <i class="ci img-golf-cup-search"></i>
    <div class="bvc pagination-block">
      <?php echo $this->Paginator->prev();?>
      <ul>
        <?php echo $this->Paginator->numbers(['tag'=>'li']);?>
      </ul>
      <?php echo $this->Paginator->next();?>
    </div>
  </section>
</section>