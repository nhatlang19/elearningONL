<?php

trait ExportCsvTrait
{

    public function exportToCsvTemp($filename, $data = [])
    {
        $f = fopen($filename, "w");
        foreach ($data as $line) {
            fputcsv($f, $line, '|', ' ');
        }
        fclose($f);
    }
}