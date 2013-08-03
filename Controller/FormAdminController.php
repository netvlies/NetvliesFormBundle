<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\Controller;

use Netvlies\Bundle\NetvliesFormBundle\Entity\Form;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

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
                $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, implode(', ', (array) $entry->getValue()));
                $ord++;
            }
            $excel->getActiveSheet()->SetCellValue(chr($ord).$rowNumber, $result->getDatetimeAdded()->format('Y-m-d H:i:s'));

            $rowNumber++;
        }

        $writer = new PHPExcel_Writer_Excel2007($excel);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="form_'.$form->getId().'_'.date('YmdHis').'.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->setContent($content);

        return $response;
    }
}
