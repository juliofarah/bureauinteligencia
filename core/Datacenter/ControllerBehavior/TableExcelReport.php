<?php
/**
 * Description of TableExcelReport
 *
 * @author raigons
 */
class TableExcelReport extends TableReport{
    
    protected function buildResponse($response) {
        $spreadsheetName = $response;
        $path = LinkController::getBaseURL() . "/" . $spreadsheetName;
        return $this->jsonResponse->response(true, null)
                            ->addValue("planilha",$path)
                            //->addValue("asHtml", $this->buildExcelHTML($spreadsheetName))
                            ->withoutHeader()->serialize();
    }
    
    private function buildExcelHTML($spreadsheetFile){        
        $data = new Spreadsheet_Excel_Reader($spreadsheetFile);
        return $data->dump(true, true);
    }
}

?>
