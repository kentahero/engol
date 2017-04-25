      <div class="box">
        <div class="title-block is-clearfix">
          <span class="icon left">
            <i class="ci img-ball-search"></i>
          </span>
          <p class="is-pulled-left name"><span class="<?=$group->users[0]->sex_class?>"><?=$this->Text->truncate($group->users[0]->nickname,9)?></span> & <span class="<?=$group->users[1]->sex_class?>"><?=$this->Text->truncate($group->users[1]->nickname,9)?></span> ペア</p>
          <!--<p class="is-pulled-right status">ログイン：本日</p>-->
        </div>
        <div class="pair-block">
          <div class="card">
            <a class="card-link" href="/profile/index/<?=$group->users[0]->id?>">
              <div class="card-image">
                <figure class="image is-4by3">
                  <?php if($group->users[0]->companion_info->image != 0) {?>
                  <img src="/img/pic/pic_<?=$group->users[0]->id?>_1.jpg" alt="Image">
                  <?php }else{?>
                  <img src="/img/pic/nophoto.png" alt="Image">
                  <?php }?>
                </figure>
              </div>
              <div class="user-attr <?=$group->users[0]->sex_class?>">
                <p class="name"><?=$this->Text->truncate($group->users[0]->nickname,11)?></p>
                <p class="age"><?=$group->users[0]->display_age?>歳(<?=$group->users[0]->sex_name?>)</p>
                <p class="current-pref"><?=$group->users[0]->prefecture->name?></p>
              </div>
            </a>
          </div>
          <span class="icon pair-cross">
            <i class="ci img-cross"></i>
          </span>
          <div class="card">
            <a class="card-link" href="/profile/index/<?=$group->users[1]->id?>">
              <div class="card-image">
                <figure class="image is-4by3">
                  <?php if($group->users[1]->companion_info->image != 0) {?>
                  <img src="/img/pic/pic_<?=$group->users[1]->id?>_1.jpg" alt="Image">
                  <?php }else{?>
                  <img src="/img/pic/nophoto.png" alt="Image">
                  <?php }?>
                </figure>
              </div>
              <div class="user-attr <?=$group->users[1]->sex_class?>">
                <p class="name"><?=$this->Text->truncate($group->users[1]->nickname,11)?></p>
                <p class="age"><?=$group->users[1]->display_age?>歳(<?=$group->users[1]->sex_name?>)</p>
                <p class="current-pref"><?=$group->users[1]->prefecture->name?></p>
              </div>
            </a>
          </div>
        </div>
      </div>