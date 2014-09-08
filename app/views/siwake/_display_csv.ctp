<?php $this->set('title_for_layout', "作成結果"); ?>
<?php $tax_type_name = tlist("tax_type_name"); //課税区分名称 ?>
<h3>送信された元帳データ</h3>
<div class="download"><?php echo $html->link("仕訳データをダウンロード", "/siwake/downloadCsv/{$siwake_name}"); ?></div>
<table class="upload">
	<?php foreach($csv_data as $k => $v){ ?>
		<?php if($k == 0){ ?>
			<tr>
				<th><?php echo $v[0]; ?></th>
				<th><?php echo $v[1]; ?></th>
				<th><?php echo $v[2]; ?></th>
				<th><?php echo $v[3]; ?></th>
				<th><?php echo $v[4]; ?></th>
				<th>エラー内容</th>
			</tr>
		<?php }else{ ?>
			<tr <?php if(!empty($err_msg[$k])){ echo "class='err'"; } ?>>
				<td><?php echo $v[0]; ?></td>
				<td><?php echo $v[1]; ?></td>
				<td><?php echo $v[2]; ?></td>
				<td class="amount"><?php echo $v[3]; ?></td>
				<td class="amount"><?php echo $v[4]; ?></td>
				<td><?php if(!empty($err_msg[$k])){ echo $err_msg[$k]; } ?></td>
			</tr>
		<?php }?>
	<?php } ?>
</table>

<h3>作成された仕訳データ</h3>
<div class="download"><?php echo $html->link("仕訳データをダウンロード", "/siwake/downloadCsv/{$siwake_name}"); ?></div>
<table class="siwake">
	<tr>
		<th>日付</th>
		<th>借方科目</th>
		<th>借方課税区分</th>
		<th>金額</th>
		<th>貸方科目</th>
		<th>貸方課税区分</th>
		<th>金額</th>
		<th>摘要</th>
	</tr>
	<?php foreach($siwake_data as $k => $v){ ?>
		<tr>
			<td><?php echo $v["date"]; ?></td>
			<td><?php echo $v["kari_name"]; ?></td>
			<td><?php echo $tax_type_name[$v["kari_tax_type"]]; ?></td>
			<td class="amount"><?php echo number_format($v["kari_amount"]); ?></td>
			<td><?php echo $v["kasi_name"]; ?></td>
			<td><?php echo $tax_type_name[$v["kasi_tax_type"]]; ?></td>
			<td class="amount"><?php echo number_format($v["kasi_amount"]); ?></td>
			<td><?php echo $v["note"]; ?></td>
		</tr>
	<?php } ?>
</table>
<div class="download"><?php echo $html->link("仕訳データをダウンロード", "/siwake/downloadCsv/{$siwake_name}"); ?></div>
<div class="menu"><?php echo $html->link("ホームへ戻る", "/"); ?></div>