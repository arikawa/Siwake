<?php
// ¶R[hÍS-JISÉ·é±Æ
foreach ($siwake_data as $k => $v) {
	$csv->addField(2000); //¯ÊtbO
	$csv->addField(""); //`[No
	$csv->addField(""); //Z
	$csv->addField($v["date"]); //æøú
	$csv->addField($v["kari_name"]); //Øû¨èÈÚ
	$csv->addField(""); //ØûâÈÚ
	$csv->addField(""); //Øûå
	$csv->addField($tax_type_name[$v["kari_tax_type"]]); //ØûÅæª
	$csv->addField($v["kari_amount"]); //Øûàz
	$csv->addField(""); //ØûÅàz
	$csv->addField($v["kasi_name"]); //Ýû¨èÈÚ
	$csv->addField(""); //ÝûâÈÚ
	$csv->addField(""); //Ýûå
	$csv->addField($tax_type_name[$v["kasi_tax_type"]]); //ÝûÅæª
	$csv->addField($v["kasi_amount"]); //Ýûàz
	$csv->addField(""); //ÝûÅàz
	$csv->addField($v["note"]); //Ev
	$csv->addField(""); //Ô
	$csv->addField(""); //úú
	$csv->addField(0); //^Cv
	$csv->addField(""); //¶¬³
	$csv->addField(""); //dó
	$csv->addField(""); //tâ³1
	$csv->addField(""); //tâ³2
	$csv->addField("no"); //²®
    $csv->endRow();
}
$csv->setFilename($file_name);
echo $csv->render();