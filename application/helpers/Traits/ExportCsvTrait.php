<?php

trait ExportCsvTrait
{

    public function exportToCsvTemp($filename, $data = [])
    {
        $f = fopen($filename, "w");
        foreach ($data as $line) {
            fputs($f, implode($line, '|')."\n");
        }
        fclose($f);
    }
}
