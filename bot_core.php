<?php
//Botクラス

//ユーティリティファイルの読み込み
require_once("util.php");
//Responderクラスの読み込み
require_once("responder.php");
//Oauthライブラリの読み込み
require_once("./oauth/twitteroauth.php");
//Botクラスの定義
class Bot{
	//メンバ変数
	//ユーザ名を格納する変数
	var $user;
	//OAuthオブジェクトを格納する変数
	var $Obj;
	//Responderオブジェクトを格納する変数
	var $responder;
	
	//コンストラクタ（初期化用メソッド）
	function Bot($usr, $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret){
		$this->user = $usr;
		//OAuthオブジェクトの生成
		$this->Obj = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
		//Responderオブジェクトの生成
		$this->responder = new Responder("OneWord");
	}
	
	//リクエストを送信するメソッド
	function Request($url, $method="POST", $opt=array()){
		$req = $this->Obj->OAuthRequest("http://api.twitter.com/1/".$url, $method, $opt);
		$result = $req ? $req : null ;
		return $result;
	}
	
	//ツイートを送信するメソッド
	function Post($status){
		//送信する文字列（$status）をリクエストパラメータにセットする
		$opt = array();
		$opt["status"] = $status;
		//リクエストを送信する
		$req = $this->Request("statuses/update.xml", "POST", $opt);
		return $req;
	}
	
	//テキストをResponderオブジェクトに渡すメソッド
	function Speaks($input){
		return $this->responder->Response($input);
	}
	
	//Responderオブジェクトの名前を返すメソッド
	function ResponderName(){
		return $this->responder->Name();
	}
	
	//タイムラインを取得するメソッド
	function GetTimeline($type, $sid = null, $count = 30){
		//リクエストパラメータのセット
		$opt = array();
		//$countは取得数(最大200)
		$opt['count'] = $count;
		//$sidはツイート、リプライの発言ID
		if($sid){
			$opt["since_id"] = $sid;
		}
		//JSON形式でタイムラインを取得する
		//$req = $this->Request("statuses/".$type.".json", "GET", $opt);
		$req = $this->Request("statuses/user_timeline/".TWIT_EN_ACCOUNT.".json", "GET", $opt);
		//PHP配列に変換する
		$result = json_decode($req);
		//エラー処理
		if(!is_array($result)){ die("Error"); }
		//配列を逆順にして返す
		return array_reverse($result);
	}
}
