<?php
namespace App\Libraries\Word;

use PhpOffice\PhpWord\PhpWord;

class PhpWordSingleton
{
    private $phpWord;

    protected static $instance = null;

    protected function __construct()
    {
        # Thou shalt not construct that which is unconstructable!
        $this->phpWord = new PhpWord();
    }

    protected function __clone()
    {
        # Me not like clones! Me smash clones!
    }

    public function getObject() {
        return $this->phpWord;
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
        if (method_exists($this->phpWord, $method)) {
            return call_user_func_array([$this->phpWord, $method], $arguments);
        }

        return null;
    }

    /**
     * Load template by filename
     *
     * @deprecated 0.12.0 Use `new TemplateProcessor($documentTemplate)` instead.
     *
     * @param  string $filename Fully qualified filename.
     * @return TemplateProcessor
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function loadTemplate($filename)
    {
        if (file_exists($filename)) {
            return new CustomTemplateProcessor($filename);
        } else {
            throw new \Exception("Template file {$filename} not found.");
        }
    }
}
