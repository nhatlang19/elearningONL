<?php
namespace App\Libraries\Excel;

use PHPExcel;
use PHPExcel_Writer_Excel5;

class PhpExcelSingleton
{
    private $phpExcel;

    protected static $instance = null;

    protected function __construct()
    {
        # Thou shalt not construct that which is unconstructable!
        $this->phpExcel = new PHPExcel();
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
        if (method_exists($this->phpExcel, $method)) {
            return call_user_func_array([$this->phpExcel, $method], $arguments);
        }

        return null;
    }

    public function download($fileName)
    {
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer = new \PHPExcel_Writer_Excel5($this->phpExcel);
        $writer->save('php://output');
    }
}
