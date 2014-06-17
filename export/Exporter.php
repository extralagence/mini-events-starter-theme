<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 13/06/2014
 * Time: 12:28
 */

/** Include PHPExcel */
require_once '../includes/PHPExcel/Classes/PHPExcel.php';

class Exporter {

	private static $instance = null;
	public static function get_instance() {
		if (self::$instance === null) {
			self::$instance = new Exporter();
		}

		return self::$instance;
	}

	public function export($lines) {

		$form = Config::get_form();
		$fields = $form->get_fields_for_export();

		PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

		$xls_file = $this->create_xls_file();

		/** @var PHPExcel_Worksheet $xls_sheet */
		$xls_sheet = $this->create_xls_sheet($xls_file, "Inscriptions", $fields, true);
		$xls_row_id = 2;

		foreach( $lines as $line ) {
			$this->create_xls_row($xls_sheet, $line, $fields, $xls_row_id);
			$xls_row_id++;
		}

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$xls_file->setActiveSheetIndex(0);
		
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Europe/Paris');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="export-reservations-'.date('d-m-Y-H\hi').'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($xls_file, 'Excel2007');
		$objWriter->save('php://output');
		die;
	}

	/**
	 * @param $xls_sheet \PHPExcel_Worksheet
	 * @param $booking_row mixed|array
	 * @param $xls_row_id int
	 */
	protected function create_xls_row(&$xls_sheet, $line, $fields, $xls_row_id) {
		$i = 0;
//		foreach ($line as $value) {
//			$xls_sheet->setCellValueByColumnAndRow($i, $xls_row_id, $value);
//			$xls_sheet->getCellByColumnAndRow($i, $xls_row_id);
//			$xls_sheet->getStyleByColumnAndRow($i, $xls_row_id)->getAlignment()->setWrapText(true);
//			$i++;
//		}
		/** @var \fields\AbstractField $field */
		foreach ($fields as $field) {
			$xls_sheet->setCellValueByColumnAndRow($i, $xls_row_id, $field->get_value_for_export($line));
			$xls_sheet->getCellByColumnAndRow($i, $xls_row_id);
			$xls_sheet->getStyleByColumnAndRow($i, $xls_row_id)->getAlignment()->setWrapText(true);
			$i++;
		}
	}

	/**
	 * @return \PHPExcel
	 */
	protected function create_xls_file() {
		$xls_file = new PHPExcel();
		// Set document properties
		$xls_file->getProperties()->setCreator("Extra l'agence")
			->setLastModifiedBy("Extra l'agence")
			->setTitle("Export des réservations")
			->setSubject("Export des réservations")
			->setDescription("Export des réservations")
			->setKeywords("export réservations")
			->setCategory("export réservations");

		return $xls_file;
	}


	/**
	 * @param $xls_file \PHPExcel
	 * @param $sheet_name string
	 * @param $col_templates mixed|array
	 *
	 * @return PHPExcel_Worksheet
	 */
	protected function create_xls_sheet(&$xls_file, $sheet_name, $fields, $first) {
		if ($first) {
			$xls_sheet = $xls_file->getSheet(0);
			$xls_sheet->setTitle($sheet_name);
		} else {
			$xls_sheet = new \PHPExcel_Worksheet($xls_file, $sheet_name);
			$xls_file->addSheet($xls_sheet);
		}
		$i = 0;
		/** @var \fields\AbstractField $field */
		foreach ($fields as $field) {
			$xls_sheet->setCellValueByColumnAndRow($i, 1, $field->label);
			$xls_file->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
			$xls_file->getActiveSheet()->getStyleByColumnAndRow($i, 1)->getFont()->setBold(true);
			$i++;
		}

		return $xls_sheet;
	}
} 