<?php
include('utiles.php') ;
require_once 'librerias/excel/PHPExcel.php';

$_tipo = $_GET['tipo'];
$_sql = urldecode($_GET['sql']);
$_sql = str_replace('\\', "", $_sql);

$excel_row = 2;
$excel_columns = array(
	"id_unico" => 'A',
	"pras" => 'B',
	"auditoria_ejercicio" => 'C',
	"EnteFiscalizador" => 'D',
	"Fondo_o_Programa" => 'E',
	"EjecutoraDependencias" => 'F',
	"EjecutoraMpios" => 'G',
	"no_auditoria" => 'H',
	"no_resultado" => 'I',
	"descrip_observa" => 'J',
	"solicitud_inicio_fecha" => 'K',
	"no_proced" => 'L',
	"dependencia_presunto_resp" => 'M',
	"nombre_presuntores" => 'N',
	"monto_observado" => 'O',
	"organo_control_interno" => 'P',
	"fecha" => 'Q',
	"resultado_final" => 'R',
	"id_estatus" => 'S'
);

$objPHPExcel = new PHPExcel();

//creamos la conexion a la bd y generamos la consulta
$link=Conectarse();

$result3=$link->query("SELECT * FROM ctra1_catalogos WHERE enuso=1 ORDER BY tp, concepto ");
$result3->execute();
$row3=$result3->fetchAll(PDO::FETCH_ASSOC);

$conceptos=array();
foreach ($row3 as $row1) {
	$conceptos[$row1['id_unico']]=$row1['concepto'];
}


$result1=$link->query($_sql);
$row_count1=$result1->rowCount();

if ($row_count1>0){
/*
	$rsResponsables=mysql_query("SELECT IdResp, Responsable FROM cyn_ac_ct_responsables WHERE EnUso=1 ORDER BY Responsable ",$link);
	if (mysql_num_rows($rsResponsables)>0){
		while($row88=mysql_fetch_assoc($rsResponsables)){
			$respo[$row88['IdResp']]=$row88['Responsable'];
		}
	}
*/

$borders = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
		)
	),
);

function esImpar($numero) {
	return $numero & 1; // 0 = es par, 1 = es impar
}

	if ($_tipo == 'excel'){
		$excelObj = $objPHPExcel->getProperties();
		$excelObj->setCreator("Gobierno del Estado de Tamaulipas");
		$excelObj->setLastModifiedBy("Gobierno del Estado de Tamaulipas");
		$excelObj->setTitle("PRAS");
		$excelObj->setSubject("Reporte Personalizado");
		$excelObj->setDescription("Reporte Personalizado");
		$excelObj->setKeywords("reporte");
		$excelObj->setCategory("reporte");

		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

		foreach ($excel_columns as $key => $value) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($value."1",strtoupper($key));
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($value.'1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($value.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('faa62f');
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($value.'1')->getFont()->setSize(10);
#color de celda por rangos
#		$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('faa62f');
#color de fuente
#			$objPHPExcel->setActiveSheetIndex(0)->getStyle($value.'1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		}

		while($row=$result1->fetch(PDO::FETCH_ASSOC)) {
			foreach ($row as $key=>$value) {
				if (array_key_exists($key, $excel_columns)) {
					$ban=0;

					if ($key=='auditoria_ejercicio') {
						$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as auditorias ";
						$result8.=" FROM ctra1_cat_selecc cs ";
						$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
						$result8.=" WHERE cs.id_pras=? and (cs.id_campo=1) ";
						$result8.=" ORDER BY cs.id_campo ";
						$result8=$link->prepare($result8);
						$result8->execute(array($value));
						$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
						$row_count8=$result8->rowCount();

						$auditorias="";
						if ($row_count8>0){
							foreach ($row8 as $row8c) {
								$auditorias.=$row8c['auditorias'];
							}
						}

						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $auditorias);
						$ban=1;
					}

					if ($key=='EnteFiscalizador') {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $conceptos[$value]);
						$ban=1;
					}

					if ($key=='Fondo_o_Programa') {
						$fondo_paso=Explode("*", $value);

						switch ($fondo_paso[0]) {
						case '0':
							$fondo='-';
							break;
						case '1':
							$fondo=$conceptos[$fondo_paso[1]];
							break;
						case '2':
							$fondo=$conceptos[$fondo_paso[2]];
							break;
						}

						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $fondo);
						$ban=1;
					}

					if ($key=='EjecutoraDependencias') {
						$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as eje_depen ";
						$result8.=" FROM ctra1_cat_selecc cs ";
						$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
						$result8.=" WHERE cs.id_pras=? and (cs.id_campo=2) ";
						$result8.=" ORDER BY cs.id_campo ";
						$result8=$link->prepare($result8);
						$result8->execute(array($value));
						$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
						$row_count8=$result8->rowCount();

						$eje_depen="";
						if ($row_count8>0){
							foreach ($row8 as $row8c) {
								$eje_depen.=$row8c['eje_depen'];
							}
						}

						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $eje_depen);
						$ban=1;
					}

					if ($key=='dependencia_presunto_resp') {
						$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as depen_pres_resp ";
						$result8.=" FROM ctra1_cat_selecc cs ";
						$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
						$result8.=" WHERE cs.id_pras=? and (cs.id_campo=4) ";
						$result8.=" ORDER BY cs.id_campo ";
						$result8=$link->prepare($result8);
						$result8->execute(array($value));
						$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
						$row_count8=$result8->rowCount();

						$depen_pres_resp="";
						if ($row_count8>0){
							foreach ($row8 as $row8c) {
								$depen_pres_resp.=$row8c['depen_pres_resp'];
							}
						}

						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $depen_pres_resp);
						$ban=1;
					}

					if ($key=='EjecutoraMpios') {
						$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as eje_mpios ";
						$result8.=" FROM ctra1_cat_selecc cs ";
						$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
						$result8.=" WHERE cs.id_pras=? and (cs.id_campo=3) ";
						$result8.=" ORDER BY cs.id_campo ";
						$result8=$link->prepare($result8);
						$result8->execute(array($value));
						$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
						$row_count8=$result8->rowCount();

						$eje_mpios="";
						if ($row_count8>0){
							foreach ($row8 as $row8c) {
								$eje_mpios.=$row8c['eje_mpios'];
							}
						}

						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $eje_mpios);
						$ban=1;
					}

					if ($key=='organo_control_interno') {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $conceptos[$value]);
						$ban=1;
					}

					if ($key=='id_estatus') {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $conceptos[$value]);
						$ban=1;
					}

					if ($ban==0){
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_columns[$key].$excel_row, $value);
					}

				}
			}

			if (esImpar($excel_row)){
				$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':S'.$excel_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2');
			}

			$excel_row++;
		}
	}
}


$objPHPExcel->getActiveSheet()->setTitle('Reporte Personalizado');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_per.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

$link=null;
exit();
?>