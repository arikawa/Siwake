<?php
class Csv extends AppModel {

	var $name = 'Csv';  
	var $useTable = false;
	
	/* アップロードファイルをチェック */
	function uploadCheck($data){
		/*ファイル未選択 */
		if(empty($data["tmp_name"])){
			return array(false, "ファイルを選択して下さい。");
		}
		/* CSV以外 */
		if($data["type"] != 'application/vnd.ms-excel'){
			return array(false, "CSV形式ではありません。");
		}
		/* サイズオーバー */
		if(filesize($data["tmp_name"]) > UPLOAD_MAX_SIZE){
			return array(false, "ファイルのサイズは" . UPLOAD_MAX_SIZE / 1000000 . "MB以下にしてください。");
		}
		return array(true, "");
	}
	
	/* アップロードファイルを保存 */
	function saveFile($up_file){
	 	/* アップロードファイルチェック */
		if (!is_uploaded_file($up_file)){
			return false;
		}
		/* アップロードファイル移動 */
		$file_name = UPLOAD_FILE_PATH . "csv" . date("YmdHis") ."_" . mt_rand(1000, 9999) . ".csv";
		if(!move_uploaded_file($up_file, $file_name)){
			return false;
		}
		return $file_name;
	}
	
	/* アップロードファイルを削除 */
	function deleteFile($file_name){
		unlink($file_name);
	}
		
	/* CSVファイルのデータを配列で返す */
	function loadFromCSV($file_name) {
		$data = array();
		if (($handle = fopen($file_name, "r")) !== FALSE) {
			while (($line = fgetcsv_reg($handle, 1000, ",")) !== FALSE) {
				if(!empty($line)){
					$data[] = $line;
				}
			}
			fclose($handle);
		}
		$data = $this->convertInnerEncoding($data); //UTF-8へ変換
		return $data;
	}
	
	/* CSVデータを内部エンコード(UTF-8)へ変換 */
	function convertInnerEncoding($data){
		mb_convert_variables('UTF-8', 'SJIS-win', $data);
		return $data;
	}
	
	/* CSVデータを外部エンコード(SJIS)へ変換 */
	function convertOuterEncoding($data){
		mb_convert_variables('SJIS-win', 'UTF-8', $data);
		return $data;
	}
	
}

