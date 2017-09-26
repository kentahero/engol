      <div class="box">
        <div class="title-block is-clearfix">
          <span class="icon left">
            <i class="ci img-ball-search"></i>
          </span>
          <?php if (count($group->users) >= 2) {?>
          <p class="is-pulled-left name"><span class="<?=$group->users[0]->sex_class?>"><?=$this->Text->truncate($group->users[0]->nickname,9)?></span> & <span class="<?=$group->users[1]->sex_class?>"><?=$this->Text->truncate($group->users[1]->nickname,9)?></span> ペア</p>
          <?php } else {?>
          <p class="is-pulled-left name"><span class="<?=$group->users[0]->sex_class?>"><?=$this->Text->truncate($group->users[0]->nickname,9)?></span></p>
          <?php }?>
          <!--<p class="is-pulled-right status">ログイン：本日</p>-->
        </div>
        <div class="pair-block">
          <?php
          $j=0;
          foreach($group->users as $user) {
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
          <?php if ($j==0 && count($group->users) >= 2) {?>
          <span class="icon pair-cross">
            <i class="ci img-cross"></i>
          </span>
          <?php
              }
              $j++;
            }
          ?>
      </div>