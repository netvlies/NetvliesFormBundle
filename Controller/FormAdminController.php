<?php

namespace Netvlies\Bundle\NetvliesFormBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Netvlies\Bundle\NetvliesFormBundle\Entity\Form;
use PHPExcel;
use PHPExcel_Writer_Excel2007;

class FormAdminController extends CRUDController
{
    public function resultsAction(Form $form)
    {
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);

        $rowNumber = 1;
        foreach ($form->getResults() as $result) {

            if ($rowNumber == 1) {
                $ord = ord('A');
                foreach ($result->getEntries() as $entry) {
                    $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, $entry->getField()->getLabel());
                    $ord++;
                }
                $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, 'Datum');

                $rowNumber++;
            }

            $ord = ord('A');
            foreach ($result->getEntries() as $entry) {
                $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, $entry->getValue());
                $ord++;
            }
            $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, $result->getDatetimeAdded()->format('Y-m-d H:i:s'));

            $rowNumber++;
        }

        // @todo Rewrite to return nice Symfony Response object
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="form_'.$form->getId().'_'.date('YmdHis').'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new PHPExcel_Writer_Excel2007($excel);
        $writer->save('php://output');

        die;
    }
}
