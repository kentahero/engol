
この度はエンゴルにお申込み頂きまして誠にありがとうございます。
以下の通りゴルファーの登録が完了しましたので確認下さい。

<?php if (!$member) {?>
---------------------------
個人情報
---------------------------
■メールアドレス：<?=$User->email?>

■お名前：<?=$User->first_name?> <?=$User->last_name?>

■お名前カナ：<?=$User->first_kana?> <?=$User->last_kana?>

■ニックネーム：<?=$User->nickname?>

■性別：<?=$User->sex_name?>

■生年月日：<?=$User->birth->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■郵便番号：<?=$User->postal?>

■都道府県：<?=$User->prefecture_name?>

■市区町村：<?=$User->city_name?>

■町名番地：<?=$User->address1?>

■建物名・部屋番号：<?=$User->address2?>

■電話番号：<?=$User->tel?>
<?php } ?>

---------------------------
ゴルファー情報
---------------------------
■ＰＲ：<?=$CompanionInfo->pr?>

■平均スコア：<?=$CompanionInfo->average_score?>

■ラウンド曜日：<?=$CompanionInfo->round_week_str?>

■練習場曜日：<?=$CompanionInfo->training_week_str?>

■ゴルフ場エリア：<?=$CompanionInfo->course_prefecture_name?>

■練習場エリア：<?=$CompanionInfo->training_prefecture_name?>

■ゴルフ歴：<?=$CompanionInfo->history?>

■ご職業：<?=$CompanionInfo->job?>

■設定料金：<?=$CompanionInfo->amount?>

■プレイ費：<?=$CompanionInfo->play_amount_kind_name?>

■ペアの方のメールアドレス：<?=$CompanionInfo->pair_emai?>

---------------------------
お振込先情報
---------------------------
■金融機関名：<?=$CompanionInfo->payment_bank?>

■支店名：<?=$CompanionInfo->payment_shop_name?>

■口座種別：<?=$CompanionInfo->payment_bank_kind_name?>

■口座番号：<?=$CompanionInfo->payment_no?>

■口座名義：<?=$CompanionInfo->payment_name?>


お相手よりオファーがあった際にはログインしてメールボックスより3日以内にご返答をお願いいたします。

※本メールにお心当たりがない場合には以下にお問い合わせ下さい
　EMail: info@engol.jp

---------------------------------------------------------------
エンゴル運営事務局
Web: https://www.engol.jp/
EMail: info@engol.jp
---------------------------------------------------------------
