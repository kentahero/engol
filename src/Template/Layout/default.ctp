<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="/appletouchicon.png">
  <meta name="apple-mobile-web-app-title" content="エンゴル">
  <meta name="generator" content="pandoc">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>ゴルフのお相手探しエンゴル | <?= $title ?></title>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->css(array('font-awesome.min','slick','slick-theme','bulma','app')) ?>
  <?= $this->Html->script(array('lib/jquery-3.1.1.min','lib/jquery-ui-1.12.1/jquery-ui.min','lib/slick/slick.min','lib/slick/slick.min','app')) ?>
  <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
  <![endif]-->

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  <?= $this->element('analytics') ?>
</head>
<body>
<?= $this->element('header') ?>
<?= $this->fetch('content') ?>
<?= $this->element('footer') ?>
<p class="pagetop"><a href="#wrap"><i class="fa fa-arrow-up"></i></a></p>
</body>
</html>
