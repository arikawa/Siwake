<?php $this->set('title_for_layout', "便利ファイル"); ?>

<div class="template-file"><?php echo $html->link('CSVフォーマット', 'downloadFormat'); ?></div>
<div class="template-explain">
	当サイトで弥生会計用の仕訳データを自動作成するためのCSVフォーマットです。<br />
	使い方は<?php echo $html->link('こちら', 'howto'); ?>をご参照ください。
</div>


<div class="template-file"><?php echo $html->link('現金出納帳(CSVフォーマット対応)', 'downloadCashbook'); ?><br /></div>
<div class="template-explain">
	当サイトのCSVフォーマットへデータをコピーしやすい現金出納帳です。<br />
	当サイトを今後定期的に利用される際は、こちらの現金出納帳をご利用いただくと便利です。<br />
	<span class="attention">こちらの現金出納帳をそのままアップロードすることはできませんのでご注意下さい。</span>
</div>
