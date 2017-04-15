<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<section class="main-content">
<div class="brcb-area bg-green mb20">
  <ul class="brcb">
    <li class="strong"><a href="">トップ</a></li>
    <li><a href="">エラー発生</a></li>
  </ul>
  <a class="bvc back-btn-link" href="./index.html">
    <img class="back-btn bvc" src="./img/icon-back.png">
    <span class="back-btn-name">戻る</span>
  </a>
</div>
<div class="other-content">
  <h1 class="title">エラー発生</h1>
  <section class="section">
    <strong><?= __d('cake', 'Error') ?>: </strong>
     <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
  </section>
</div>
</section>
