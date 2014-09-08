<?php
// •¶šƒR[ƒh‚ÍS-JIS‚É‚·‚é‚±‚Æ
foreach ($siwake_data as $k => $v) {
	$csv->addField(2000); //¯•Êƒtƒ‰ƒbƒO
	$csv->addField(""); //“`•[No
	$csv->addField(""); //ŒˆZ
	$csv->addField($v["date"]); //æˆø“ú
	$csv->addField($v["kari_name"]); //Ø•ûŠ¨’è‰È–Ú
	$csv->addField(""); //Ø•û•â•‰È–Ú
	$csv->addField(""); //Ø•û•”–å
	$csv->addField($tax_type_name[$v["kari_tax_type"]]); //Ø•ûÅ‹æ•ª
	$csv->addField($v["kari_amount"]); //Ø•û‹àŠz
	$csv->addField(""); //Ø•ûÅ‹àŠz
	$csv->addField($v["kasi_name"]); //‘İ•ûŠ¨’è‰È–Ú
	$csv->addField(""); //‘İ•û•â•‰È–Ú
	$csv->addField(""); //‘İ•û•”–å
	$csv->addField($tax_type_name[$v["kasi_tax_type"]]); //‘İ•ûÅ‹æ•ª
	$csv->addField($v["kasi_amount"]); //‘İ•û‹àŠz
	$csv->addField(""); //‘İ•ûÅ‹àŠz
	$csv->addField($v["note"]); //“E—v
	$csv->addField(""); //”Ô†
	$csv->addField(""); //Šú“ú
	$csv->addField(0); //ƒ^ƒCƒv
	$csv->addField(""); //¶¬Œ³
	$csv->addField(""); //d–óƒƒ‚
	$csv->addField(""); //•tâ³1
	$csv->addField(""); //•tâ³2
	$csv->addField("no"); //’²®
    $csv->endRow();
}
$csv->setFilename($file_name);
echo $csv->render();