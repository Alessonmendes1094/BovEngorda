<?php


namespace App\Utils;


use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelUtils
{
    public static function loadPlanilha($file)
    {
        $dados = array();
        $reader = self::getInstanceByTypeFile($file);
        if (isset($reader)) {
            $spreadsheet = $reader->load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $dados = array();
            foreach ($sheet->getRowIterator() as $rowSheet) {
                $row = array();
                $cellIterator = $rowSheet->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    if($cell->getCalculatedValue()){
                        array_push($row, $cell->getCalculatedValue());
                    }
                }
                array_push($dados, $row);
            }
        }
        return $dados;
    }

    private static function getInstanceByTypeFile($file)
    {
        $extensions = $file->getClientOriginalExtension();
        if ($extensions == "xlsx") {
            return new Xlsx();
        } elseif ($extensions == "xls") {
            return new Xls();
        }
        return null;
    }
}
