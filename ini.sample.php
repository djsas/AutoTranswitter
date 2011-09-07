<?php

//初期設定

//エンコードに使用する言語の設定
mb_language("Japanese");
//ボットのユーザ名
$user = "機械翻訳されたつぶやきの投稿先アカウント";
//キー・トークンの設定
//Consumer key
$consumer_key = "Twiter Consumer Key";
//Consumer secret
$consumer_secret = "Twitter Consumer Secret";
//Access Token
$access_token = "Twitter Access Token";
//Access Token Secret
$access_token_secret = "Twitter Access Token Secret";

//デバッグモードのON/OFF(1:ON, 0:OFF)
define("DEBUG_MODE", "1");

//date関数実行時のWarning対策
date_default_timezone_set('Asia/Tokyo');

// Twitter client in English
define("TWIT_EN_ACCOUNT", "機械翻訳させるつぶやき元のTwitterアカウント");
// Bing Translator API's ID
define('APP_ID', 'Bing Translatorを実行する為のAPI ID');
