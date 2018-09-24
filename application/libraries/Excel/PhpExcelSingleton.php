<?php
namespace App\Libraries\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhpExcelSingleton
{
    private $spreadSheet;

    protected static $instance = null;

    protected function __construct()
    {
        # Thou shalt not construct that which is unconstructable!
        $this->spreadSheet = new Spreadsheet();
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->spreadSheet, $method)) {
            return call_user_func_array([$this->spreadSheet, $method], $arguments);
        }

        return null;
    }

    public function downloadExcel($fileName)
    {
        $writer = new Xlsx($this->spreadSheet);

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $writer->save('php://output', 'xls');
    }
}
