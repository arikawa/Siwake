<?php
// �����R�[�h��S-JIS�ɂ��邱��
foreach ($siwake_data as $k => $v) {
	$csv->addField(2000); //���ʃt���b�O
	$csv->addField(""); //�`�[No
	$csv->addField(""); //���Z
	$csv->addField($v["date"]); //�������
	$csv->addField($v["kari_name"]); //�ؕ�����Ȗ�
	$csv->addField(""); //�ؕ��⏕�Ȗ�
	$csv->addField(""); //�ؕ�����
	$csv->addField($tax_type_name[$v["kari_tax_type"]]); //�ؕ��ŋ敪
	$csv->addField($v["kari_amount"]); //�ؕ����z
	$csv->addField(""); //�ؕ��ŋ��z
	$csv->addField($v["kasi_name"]); //�ݕ�����Ȗ�
	$csv->addField(""); //�ݕ��⏕�Ȗ�
	$csv->addField(""); //�ݕ�����
	$csv->addField($tax_type_name[$v["kasi_tax_type"]]); //�ݕ��ŋ敪
	$csv->addField($v["kasi_amount"]); //�ݕ����z
	$csv->addField(""); //�ݕ��ŋ��z
	$csv->addField($v["note"]); //�E�v
	$csv->addField(""); //�ԍ�
	$csv->addField(""); //����
	$csv->addField(0); //�^�C�v
	$csv->addField(""); //������
	$csv->addField(""); //�d�󃁃�
	$csv->addField(""); //�t�1
	$csv->addField(""); //�t�2
	$csv->addField("no"); //����
    $csv->endRow();
}
$csv->setFilename($file_name);
echo $csv->render();