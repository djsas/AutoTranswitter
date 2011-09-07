<?php
//reference => http://twbot.blogspot.com/2011/06/googleapi201112microsoft-translatorapi.html

class Translator{
	public function addNote($t){
		return $t." (auto-translated by Bing)";
	}
	function getLogs(){
		return explode("\n", file_get_contents("log.txt"));
	}
	function isAlreadyTranslated($id){
		return in_array($id, $this->getLogs());
	}
	function pushLog($id){
		file_put_contents("log.txt", "$id\n", FILE_APPEND);
	}
	function translate($t, $from, $to){
		$url = 'http://api.microsofttranslator.com/V2/Http.svc/Translate?appid='.APP_ID
        	.'&text='.urlencode($t).'&from='.$from.'&to='.$to.'&text/plain&general';
		$body = file_get_contents($url);
		$res_text = trim(strip_tags($body));
		if ($res_text == ''){
			die('ERROR ja to en.');
		}
		return $res_text;
	}
	function deleteWords($t){
		$stopwords = array("#twinglish");
		$words = explode(" ", $t);
		$out = array();
		foreach($words as $w){
			if(!in_array($w, $stopwords)){
				array_push($out, $w);
			}
		}
		return implode(" ", $out);
	}
}
