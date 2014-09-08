<?php
class SiwakeController extends AppController {

	public $name = 'Siwake';
	public $uses = array('Csv', 'Siwake');
	var $helpers = array('Html', 'Form', 'Csv');
	var $components = array('Session');
	
	/* 初期処理 */
	function beforeFilter(){
		parent::beforeFilter();
		//basic_auth(array(BASIC_USER => BASIC_PASS)); //ベーシック認証
		$tax_type_options = tlist('tax_type_options'); //消費税の処理方式　選択肢
		$agreement_options = tlist('agreement_options'); //利用規約の同意　選択肢
		$this->set(compact('tax_type_options', 'agreement_options'));
	}
	
	/* メイン処理 */
	function index(){
		/* 初表示の場合は宣伝画面へ */
		/*
		if(!$this->Session->read('Advatise.visited')){
			$this->redirect('advatise');
		}
		*/
		
		/* データ未入力なら初期表示 */
		if(!isset($this->data['Siwake'])){
			return;
		}
		
		/* 入力項目チェック */
		list($result, $msg) = $this->Siwake->inputCheck($this->data['Siwake']);
		if(!$result){ //エラーの場合
			$this->Session->setFlash($msg); //エラーメッセージ設定
			return;
		}
		
		/* アップロードファイルチェック */
		list($result, $msg) = $this->Csv->uploadCheck($this->data['Siwake']['csv']);
		if(!$result){ //エラーの場合
			$this->Session->setFlash($msg); //エラーメッセージ設定
			return;
		}
		
		/* アップロードファイル保存 */
		if(!$file_name = $this->Csv->saveFile($this->data['Siwake']['csv']['tmp_name'])){
			$this->Session->setFlash('ファイルのアップロードに失敗しました。');
			return;
		}
		
		$this->log("upload" . "\t" . basename($file_name) . "\t" . $_SERVER['REMOTE_ADDR'] . "\r\n", "siwake"); //ログ
		$csv_data = $this->Csv->loadFromCSV($file_name); //CSVファイル読み込み
		
		/* フォーマットチェック */
		if(!$this->Siwake->checkFormat($csv_data)){
			$this->Session->setFlash('フォーマットが正しくありません。');
			return;
		}
		
		list($siwake_data, $err_msg) = $this->Siwake->convertToYayoi($this->data['Siwake'], $csv_data); //仕訳データへ変換
		$siwake_name = $this->Siwake->saveData($siwake_data); //仕訳データ保存
		$this->log("change" . "\t" . $siwake_name . "\t" . $_SERVER['REMOTE_ADDR'] . "\r\n", "siwake"); //ログ
		//$this->Csv->deleteFile($file_name); //アップロードファイル削除
		
		$this->set(compact('csv_data', 'siwake_data', 'err_msg', 'siwake_name')); //Viewへセット
		$this->render('_display_csv'); //表示用View
		//$this->_downloadCsv($siwake_data); //CSVダウンロード
	}
	
	/* 仕訳データのCSVダウンロード */
	function downloadCsv($file_name){
		$siwake_data = $this->Siwake->loadData($file_name); //仕訳データ読み込み
		$this->log("download" . "\t" . $file_name . "\t" . $_SERVER['REMOTE_ADDR'] . "\r\n", "siwake"); //ログ
		$this->_downloadCsv($siwake_data); //ダウンロード
	}
	
	/* 仕訳データをCSVへ出力 */
	function _downloadCsv($siwake_data){
		$siwake_data = $this->Csv->convertOuterEncoding($siwake_data); //SJISへ変換
		$tax_type_name = $this->Csv->convertOuterEncoding(tlist('tax_type_name')); //課税区分名称を取得してSJISへ変換
		Configure::write('debug', 0); // 警告を出さない
		$this->layout = false;
		$file_name = 'Siwake_' . date('YmdHis'); // 任意のファイル名
		$this->set(compact('file_name', 'siwake_data', 'tax_type_name'));
		$this->render('_download_csv'); //CSV用View
	}
	
	/* フォーマットのダウンロード */
	function downloadFormat() {
		$this->_downloadTemplate(FORMAT_FILE_NAME);
	}
	
	/* 現金出納帳のダウンロード */
	function downloadCashbook(){
		$this->_downloadTemplate(CASHBOOK_FILE_NAME);
	}
	
	/* テンプレートダウンロード */
	function _downloadTemplate($filename) {
		$this->view = 'Media'; //メディアビューを使用
		Configure::write('debug', 0); //デバッグ無効
		$params = array(
			  'id' => $filename,
			  'name' => reset(explode('.', $filename)), //ファイル名
			  'download' => true,
			  'extension' => end(explode('.', $filename)), //拡張子
			  'path' => 'files' . DS
		);
		$this->set($params);
	}
	
	/* 利用規約 */
	function agreement(){
	}
	
	/* 宣伝ページ */
	function advatise(){
		$this->Session->write('Advatise.visited', true); //宣伝ページ表示を記録
	}
	
	/* 使い方ページ */
	function howto(){
	}
	
	/* 課税区分一覧ページ */
	function taxList(){
		$tax_type_name = tlist('tax_type_name'); //課税タイプ名取得
		$tax_type_lists = $this->Siwake->_getTaxTypeLists(); //課税タイプリスト取得
		$this->set(compact('tax_type_name', 'tax_type_lists'));
	}
	
	/* テンプレートページ */
	function template(){
	}
	
	/* お問合せ */
	function contact(){
	}
}