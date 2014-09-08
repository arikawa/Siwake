<?php $this->set('title_for_layout', "仕訳データ自動作成"); ?>
<div class="content-box">
	<?php echo $form->create(null, array('action'=>'index', 'type'=>'file')); ?>
	<fieldset>
		<?php echo $form->input('Siwake.csv', array('type'=>'file', 'label'=>'元帳データ<span style="font-size: 60%;">(' . $html->link('CSVフォーマット', 'downloadFormat') . 'に貼りつけたもの)</span>')); ?>
		<?php echo $form->input('Siwake.main_name', array('type'=>'text', 'label'=>'主科目名', 'default'=>'現金')); ?>
		<?php echo $form->input('Siwake.other_name', array('type'=>'text', 'label'=>'相手科目名(デフォルト)', 'default'=>'仮払金')); ?>
		<?php echo $form->input('Siwake.tax_type', array('type'=>'radio', 'legend'=>'消費税の処理方式', 'options'=>$tax_type_options, 'default'=>'before')); ?>
		<?php echo $form->input('Siwake.agreement', array('type'=>'radio', 'legend'=>$html->link('利用規約', 'agreement', array('target'=>'_blank')) . 'への同意', 'options'=>$agreement_options, 'default'=>'agree')); ?>
		<?php echo $form->end('ファイルを送信'); ?>
	</fieldset>
</div>
<div class="content-box howto" style="width: 50%;">
	<div class="attention">
		当サービスは会計ソフト「<?php echo $html->link("弥生会計", YAYOI_KAIKEI_URL, array("target"=>"_blank")); ?>」および
		その販売元である「<?php echo $html->link("弥生会計 株式会社", YAYOI_CORP_URL, array("target"=>"_blank")); ?>」の認定連動製品および公式サービスではありません。<br />
		従って当サービスに関する質問・要望等を<?php echo $html->link("弥生会計 株式会社", YAYOI_CORP_URL, array("target"=>"_blank")); ?>へ
		問い合わせる行為は、問い合わせ先へのご迷惑となりますので禁止いたします。
	</div>
	<h3>弥生会計インポートまでの流れ</h3>
		<ol>
		<li>
			<p class="li-title">元帳データを作成する</p>
			<?php echo $html->link('CSVフォーマット', 'downloadFormat'); ?>をダウンロードして開き、
			インターネットバンキングからダウンロードしたCSVファイルや、現金出納帳などのデータを貼り付けて保存して、元帳データを作成します。
		</li>
		<li>
			<p class="li-title">元帳データをアップロードする</p>
			<?php echo $html->link('仕訳データ自動作成', '.'); ?>画面の「ファイルを選択」ボタンから
			作成した元帳データを選択し、「ファイルを送信」ボタンを押します。
		</li>
		<li>
			<p class="li-title">仕訳データをダウンロードする</p>
			作成結果画面が表示されますので、アップロードしたデータ(上段)と作成された仕訳データ(下段)を確認し、
			「仕訳データをダウンロード」のリンクをクリックして、仕訳データを保存します。
		</li>
		<li>
			<p class="li-title">弥生会計へ仕訳データをインポートする</p>
			弥生会計の仕訳日記帳画面を開き、「ファイル」＞「インポート」から仕訳データを選択します。<br />
		</li>
	</ol>
	<div>詳細な操作方法は「<?php echo $this->Html->link('使い方', 'howto', array("target" => "_blank")); ?>」を参照して下さい。</div>
</div>
