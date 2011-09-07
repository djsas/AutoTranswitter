<?php
//タイムラインの取得
//初期設定ファイルの読み込み
require_once("ini.php");
//Botクラスの読み込み
require_once("bot_core.php");

require_once("translator.php");
//Botオブジェクトの生成
$myBot = new Bot($user, $consumer_key, $consumer_secret, $access_token, $access_token_secret);

$translator = new Translator();
//タイムラインの取得
//$mentions = $myBot->GetTimeline("home_timeline");
$mentions = $myBot->GetTimeline("user_timeline", null, 1);
//タイムラインの出力
foreach($mentions as $Timeline){
	//ユーザのスクリーン名の出力
	//$screen_name = $Timeline->user->screen_name;
	//print $screen_name.">";
	//本文をSJISに変換して出力する(コマンドプロンプトの確認用)
	//Util::Debug_print($Timeline->text);
	
	$id = $Timeline->id_str;
	if($translator->isAlreadyTranslated($id)){
		print "翻訳済みです";
	}else{
		$en_text = $Timeline->text;
		//print $en_text.PHP_EOL;
		$en_text = $translator->deleteWords($en_text);
		$ja_text = $translator->translate($en_text, "en", "ja");
		$ja_text = $translator->addNote($ja_text);
		//print $ja_text.PHP_EOL;
		
		//送信する文字列を取得する
		$text = $myBot->Speaks($ja_text);
		//コマンドプロンプトでの出力確認用
		if(DEBUG_MODE){
			Util::Debug_print($text);
		}
		
	
		//文字列が空じゃなかったらツイートを送信する
		//if($text){ $myBot->Post($text); }
		
		//$translator->pushLog($id);
	}
}