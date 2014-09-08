<?php $this->set('title_for_layout', "課税区分リスト"); ?>
<div>
	課税区分が自動で設定される科目のリストです。<br />
	元帳データのアップロード時に「消費税の処理方式」で"税込"を選んだ場合のみ設定されます。<br />
	下記リストにない科目や、「消費税の処理方式」で"免税"を選んだ場合は「対象外」が設定されます。
</div>
<div class="tax-list"; >
	<?php foreach($tax_type_lists as $k => $v){ ?>
		<ul>
			<uh><?php echo $tax_type_name[$k]; ?></uh>
			<?php $cnt = 0; ?>
			<?php foreach($v as $_k => $_v){ ?>
				<li><?php echo $_v; ?></li>
				<?php
					$cnt++;
					if(($cnt % 20) == 0){
						echo "</ul><ul><uh>&nbsp;</uh>";
					}
				?>
			<?php } ?>
		</ul>
	<?php } ?>
</div>
