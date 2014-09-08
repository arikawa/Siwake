<?php
/* 仕訳データを扱うモデル */
class Siwake extends AppModel {

	var $name = 'Siwake';  
	var $useTable = false;
	
	/* 入力内容のチェック */
	function inputCheck($data){
		/* 主科目名が未入力 */
		if(empty($data['main_name'])){
			return array(false, '主科目名が未入力です。');
		}
		
		/* 相手科目名が未入力 */
		if(empty($data['other_name'])){
			return array(false, '相手科目名(デフォルト)が未入力です。');
		}
		
		/* 利用規約に同意していない */
		if($data['agreement'] == "disagree"){
			return array(false, '利用規約に同意されない場合は利用できません。');
		}
		return array(true, null);
	}
	
	/* アップロードデータのフォーマットチェック */
	function checkFormat($data){
		$format = $this->_getFormat(); //フォーマット取得
		$title = array_slice($data[0], 0, 5); //タイトル行の必要部分のみ取得
		foreach($title as $k => $v){
			if($v != $format[$k]){
				return false;
			}
		}
		return true;
	}
	
	/* フォーマットを取得 */
	function _getFormat(){
		//$format = array("日付", "相手科目", "内容", "入金", "出金");
		$file_name = WWW_ROOT . "files". DS . FORMAT_FILE_NAME; //フォーマットファイル名
		
		if (($handle = fopen($file_name, "r")) !== FALSE) {
			$format = fgetcsv_reg($handle, 1000, ","); //1行目を取得
			mb_convert_variables('UTF-8', 'SJIS-win', $format); //UTF-8へ変換
			fclose($handle);
		}
		return $format;
	}
	
	/* CSVデータを仕訳データへ変換 */
	function convertToYayoi($input_data, $csv_data){
		$siwake_data = array(); //仕訳データ
		$err_msg = array(); //各行に対するエラーメッセージ
		$main_name = $input_data["main_name"]; //主科目
		$csv_data = $this->_getDataArea($csv_data); //必要な範囲のみ取得
		$csv_data = $this->_setKeyName($csv_data); //キー名を設定
		$csv_data = $this->_setDate($csv_data); //日付の空白を埋める
		
		/* 行毎に処理 */
		foreach($csv_data as $k => $v){
			if($k == 0) continue; //タイトルをスキップ
			
			/* エラーチェック */
			list($result, $msg) = $this->_checkLine($v);
			if(!$result){
				$err_msg[$k] = $msg; //エラーメッセージ保存
				continue; //スキップ
			}
			
			/* 変換処理 */
			$line = null;
			$line["date"] = $this->_getDate($v["date"]); //日付
			$other_name = !empty($v["other_name"]) ? $v["other_name"] : $input_data["other_name"]; //相手科目が空の場合はデフォルトの相手科目を設定
			$other_tax_type = $this->_getTaxType($input_data, $other_name); //相手科目の課税区分を取得
			if(!empty($v["kari_amount"])){ //借方金額がある場合
				$line["kari_name"] = $main_name; //借方に主科目
				$line["kasi_name"] = $other_name; //貸方に相手科目
				$line["kari_tax_type"] = TAX_TYPE_UNTAXED; //借方(主科目)を課税対象外
				$line["kasi_tax_type"] = $other_tax_type; //貸方(相手科目)の課税区分を設定
			}else{ //貸方金額がある場合
				$line["kari_name"] = $other_name; //借方に相手科目
				$line["kasi_name"] = $main_name; //貸方に主科目
				$line["kari_tax_type"] = $other_tax_type; //借方(相手科目)の課税区分を設定
				$line["kasi_tax_type"] = TAX_TYPE_UNTAXED; //貸方(主科目)を課税対象外
			}
			$line["kari_amount"] = $line["kasi_amount"] = $this->_getAmount($v); //借方金額を設定
			$line["note"] = $v["note"]; //摘要
			$siwake_data[] = $line;
		}
		return array($siwake_data, $err_msg);
	}
	
	/* CSVデータから必要な範囲のみ取得する */
	function _getDataArea($data){
		$after_data = array();
		foreach($data as $k => $v){
			$after_data[] = array_slice($v,0,5);
		}
		return $after_data;
	}
	
	/* CSVデータに仕訳データのキー名を設定 */
	function _setKeyName($data){
		$key_names = array("date", "other_name", "note", "kari_amount", "kasi_amount");
		$after_data = array();
		foreach($data as $k => $v){
			$after_data[] = array_combine($key_names, $v);
		}
		return $after_data;
	}
	
	/* CSVデータの日付の空白を埋める */
	function _setDate($data){
		$date = ""; //日付を保持
		foreach($data as $k => $v){
			/* 日付が入力されていれば保持して次へ */
			if(!empty($v["date"])){
				$date = $v["date"];
				continue;
			}
			$data[$k]["date"] = $date; //空の場合は保持した日付を入力
		}
		return $data;
	}
	
	/* CSVの行データをチェック */
	function _checkLine($line){
		/* 日付チェック */
		if(!$this->_getDate($line["date"])){
			return array(false, "日付が正しくありません。");
		}
		
		/* 金額チェック */
		if(!$this->_getAmount($line)){
			return array(false, "金額が正しくありません。");
		}
		
		return array(true, null);
	}
	
	/* 整形された日付を取得する */
	function _getDate($date){
		$date = mb_convert_kana($date, "ars"); //全角を半角に変換
		$date = trim($date); //空白削除
		$date = str_replace(array("／", ".", "-", "年", "月"),"/",$date); // 区切り文字を"/"に統一
		$date = str_replace(array("平成", "H", "Ｈ", "日"),"",$date); // 行頭・行末を削除
		/* yyyymmdd形式の場合は"/"で区切る */
		if(preg_match('/^[0-9]{8}$/', $date)){
			$date = substr($date, 0, 4) . "/" . substr($date, 4, 2) . "/" . substr($date, 6, 2);
		}
		
		/* 年が未入力の場合は現在の西暦を付与 */
		if(substr_count($date, "/") == 1){
			$date = date("Y") . "/" . $date;
		}
		
		/* 年月日を"/"で区切られていなければエラー */
		if(substr_count($date, "/") != 2){
			return false;
		}
		
		list($year, $month, $day) = explode("/", $date); //年月日に分解
		
		/* 和暦を西暦に変換(平成のみ) */
		if(strlen($year) == 2){
			$year = $year + 1988;
			$date = $year . "/" . $month . "/" . $day;
		}
		
		/* YYYY/mm/dd形式をチェック */
		if(!preg_match('/^([1-9][0-9]{3})\/([1-9]{1}|0[1-9]{1}|1[0-2]{1})\/([1-9]{1}|0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/', $date)){
			return false;
		}
		
		/* 日付の妥当性チェック */
		if(!checkdate($month, $day, $year)){
			return false;
		}
		return $date;
	}
	
	
	
	/* 金額を取得する */
	function _getAmount($line){
		/* 金額が空 */
		if(empty($line["kari_amount"]) and empty($line["kasi_amount"])){
			return false;
		}
		
		/* 金額が両方入力 */
		if(!empty($line["kari_amount"]) and !empty($line["kasi_amount"])){
			return false;
		}
		$amount = !empty($line["kari_amount"]) ? $line["kari_amount"] : $line["kasi_amount"]; //入力されている金額を取得
		$amount = mb_convert_kana($amount, "ars"); //全角を半角に変換
		$amount = trim($amount); //空白削除
		$amount = str_replace(array('￥', '\\', ','), '', $amount); //円マーク, カンマを消す
		/* 数値チェック */
		if(!is_numeric($amount)){
			return false;
		}
		return $amount;
	}
	
	/* 課税区分を取得する */
	function _getTaxType($input_data, $other_name){
		/* 非課税 */
		if($input_data["tax_type"] == 'none'){
				return TAX_TYPE_UNTAXED; //対象外
		}
		
		$tax_type_lists = $this->_getTaxTypeLists(); //課税タイプリスト取得
		/* 課税タイプリストから相手科目を検索 */
		foreach($tax_type_lists as $k => $v){
			if(in_array($other_name, $v)){
				return $k; //見つかったら課税タイプを返す
			}
		}
		
		return TAX_TYPE_UNTAXED; //対象外
	}
	
	/* 課税区分一覧を取得する */
	function _getTaxTypeLists(){
		$tax_type_lists = tlist(TAX_TYPE_KAZEI_URIAGE, TAX_TYPE_HIKAZEI_URIAGE, TAX_TYPE_KAZEI_SHIIRE); //課税タイプリスト取得
		return $tax_type_lists;
	}
	
	/* 仕訳データの保存 */
	function saveData($data){
		$file_name = "siwake" . date("YmdHis") ."_" . mt_rand(1000, 9999);
		$fp = fopen(SIWAKE_FILE_PATH . $file_name, "w");
		fwrite($fp, serialize($data));
		fclose($fp);
		
		return $file_name;
	}
	
	/* 仕訳データの読み込み */
	function loadData($file_name){
		$fp = fopen(SIWAKE_FILE_PATH . $file_name, "r");
		$data = fgets($fp);
		fclose($fp);
		return unserialize($data);
	}
}

