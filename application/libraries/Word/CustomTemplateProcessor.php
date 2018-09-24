<?php
namespace App\Libraries\Word;

use PhpOffice\PhpWord\Escaper\RegExp;
use PhpOffice\PhpWord\Escaper\Xml;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\TemplateProcessor;
use Zend\Stdlib\StringUtils;

class CustomTemplateProcessor extends TemplateProcessor
{
    protected $temporaryDocumentRels;

    public function __construct($documentTemplate)
    {
        // Temporary document filename initialization
        $this->tempDocumentFilename = tempnam(Settings::getTempDir(), 'PhpWord');
        if (false === $this->tempDocumentFilename) {
            throw new CreateTemporaryFileException();
        }

        // Template file cloning
        if (false === copy($documentTemplate, $this->tempDocumentFilename)) {
            throw new CopyFileException($documentTemplate, $this->tempDocumentFilename);
        }

        // Temporary document content extraction
        $this->zipClass = new ZipArchive();
        $this->zipClass->open($this->tempDocumentFilename);
        // Edited by Luan Nguyen
        if (! file_exists(BACKEND_V2_TRASH_PATH)) {
            mkdir(BACKEND_V2_TRASH_PATH, 0777);
        }
        $this->zipClass->extractTo(BACKEND_V2_TRASH_PATH);

        $index = 1;
        while (false !== $this->zipClass->locateName($this->getHeaderName($index))) {
            $this->tempDocumentHeaders[$index] = $this->fixBrokenMacros(
                $this->zipClass->getFromName($this->getHeaderName($index))
            );
            $index++;
        }
        $index = 1;
        while (false !== $this->zipClass->locateName($this->getFooterName($index))) {
            $this->tempDocumentFooters[$index] = $this->fixBrokenMacros(
                $this->zipClass->getFromName($this->getFooterName($index))
            );
            $index++;
        }
        $this->tempDocumentMainPart = $this->fixBrokenMacros($this->zipClass->getFromName('word/document.xml'));
        $this->temporaryDocumentRels = $this->zipClass->getFromName('word/_rels/document.xml.rels');
    }

    public function getContentTable()
    {
        $xml = $this->tempDocumentMainPart;
        $rowData = array();
        $rows = $this->_filterRows($xml);
        foreach ($rows as $row) {
            $cells = $this->_filterCells($row);
            $cellData = array();
            foreach ($cells as $cell) {
                $paragraphs = $this->_filterParagraph($cell);
                $html = array();
                foreach ($paragraphs as $key => $paragraph) {
                    $html[] = $this->_getContent($paragraph);
                }
                $cellData[] = implode('<br>', $html);
            }
            $rowData[] = $cellData;
        }
        $CI = & get_instance();
        $CI->load->library('commonobj');
        $CI->commonobj->deleteDir(BACKEND_V2_TRASH_PATH);

        return $rowData;
    }

    protected function _filterRows($resources)
    {
        $pattern = '/<w\:tr(.*?)>(.*?)<\/w\:tr>/';
        preg_match_all($pattern, $resources, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return array();
    }

    protected function _filterCells($resources)
    {
        $pattern = '/<w\:tc(.*?)>(.*?)<\/w\:tc>/';
        preg_match_all($pattern, $resources, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return array();
    }

    protected function _filterParagraph($resources)
    {
        $pattern = '/<w\:p(.*?)>(.*?)<\/w\:p>/';
        preg_match_all($pattern, $resources, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return array();
    }

    protected function _getContent($resources)
    {
        $pattern = '/<w\:r(.*?)>(.*?)<\/w\:r>/';
        preg_match_all($pattern, $resources, $matches);
        $html = '';
        if (isset($matches[0])) {
            $rows = $matches[0];
            foreach ($rows as $row) {
                $pattern = '/<w\:t(.*?)>(.*?)<\/w\:t>/';
                preg_match($pattern, $row, $matches);
                if (empty($matches)) {
                    // get images
                    $html .= $this->_getImage($row);
                } else {
                    if (isset($matches[count($matches) - 1])) {
                        $html .= $matches[count($matches) - 1] . ' ';
                    }
                }
            }
        }
        return $html;
    }

    protected function _getImage($resources)
    {
        $rId = $this->seachImagerId('<wp:docPr' , $resources);
        if(!empty($rId)) {
            $fileName = $this->getImgFileName($rId);
            if(!empty($fileName)) {
                $src = BACKEND_V2_TRASH_PATH . '/word/media/' . $fileName;

                $ext = pathinfo($src, PATHINFO_EXTENSION);
                $newFileName = md5(uniqid(mt_rand(), true)) . '.' . date('YmdHis') . '.' . $ext;

                $desc = PATH_UPLOADS_NO_ROOT . 'images/' . $newFileName;
                if(file_exists($src)) {
                    $imgThumb = imageThumb($src, $desc);
                    $newPath = base_url() . 'public/uploads/images/' . $newFileName;
                    return "<img src='$newPath' /> ";
                }
            }
        }
        return '';
    }

    /**
     * Search for the labeled image's rId
     *
     * @param string $search
     */
    public function seachImagerId($search, $resources)
    {
        if (substr($search, 0, 2) !== '${' && substr($search, - 1) !== '}') {
            $search = '${' . $search . '}';
        }
        $tagPos = strpos($resources, $search);
        $rIdStart = strpos($resources, 'r:embed="', $tagPos) + 9;
        $rId = strstr(substr($resources, $rIdStart), '"', true);
        return $rId;
    }

    /**
     * Get img filename with it's rId
     *
     * @param string $rId
     */
    public function getImgFileName($rId)
    {
        $tagPos = strpos($this->temporaryDocumentRels, '"' . $rId . '"');
        if($tagPos === false) {
            return '';
        }
        $fileNameStart = strpos($this->temporaryDocumentRels, 'Target="media/', $tagPos) + 14;
        $fileName = strstr(substr($this->temporaryDocumentRels, $fileNameStart), '"', true);

        return $fileName;
    }
}
