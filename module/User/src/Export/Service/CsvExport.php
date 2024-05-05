<?php
namespace User\Export\Service;

use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;

class CsvExport extends AbstractActionController
{
    /**
     * Response for stream file
     *
     * @param string $filename
     * @param string $attachmentFileName
     * @return \Zend\Http\Response\Stream
     */
    public function responseStreamFile($filename, $attachmentFileName)
    {
        $finfo    = new \finfo(FILEINFO_MIME);
        $response = new Stream();
        $headers  = $this->getResponse()->getHeaders();
        $headers->addHeaderLine('Content-Disposition', 'attachment; filename="' . $attachmentFileName . '"');
        $headers->addHeaderLine('Content-Type', 'text/csv');
        $headers->addHeaderLine('Content-Length', filesize($filename));
        $headers->addHeaderLine('Pragma', 'public'); // HTTP/1
        $response->setStatusCode(200);
        $response->setStream(fopen($filename, 'r'));
        $response->setStreamName(basename($filename));
        $response->setHeaders($headers);
        return $response;
    }
}
