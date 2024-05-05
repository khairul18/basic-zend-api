<?php

namespace Aqilix\Rpc;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Downloadable Trait
 */
trait DownloadableTrait
{
    /**
     *
     * @var \Zend\View\Renderer\PhpRenderer
     */
    protected $viewRenderer;

    /**
     *
     * @var \OAuth2\Server
     */
    protected $oAuth2Server;

    /**
     * @var \OAuth2\Request
     */
    protected $oAuth2Request;

    /**
     * Get the value of viewRenderer
     */
    public function getViewRenderer() :\Zend\View\Renderer\PhpRenderer
    {
        return $this->viewRenderer;
    }

    /**
     * Set the value of viewRenderer
     *
     * @param \Zend\View\Renderer\PhpRenderer $viewRenderer
     *
     * @return  self
     */
    public function setViewRenderer(\Zend\View\Renderer\PhpRenderer $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * Get the value of oAuth2Request
     */
    public function getOAuth2Request() :\OAuth2\Request
    {
        return $this->oAuth2Request;
    }

    /**
     * Set the value of oAuth2Request
     *
     * @param  \OAuth2\Request $oAuth2Request
     * @return self
     */
    public function setOAuth2Request(\OAuth2\Request $oAuth2Request)
    {
        $this->oAuth2Request = $oAuth2Request;
    }

    /**
     * Get the value of oAuth2Server
     */
    public function getOAuth2Server() :\OAuth2\Server
    {
        return $this->oAuth2Server;
    }

    /**
     * Set the value of oAuth2Server
     *
     * @return  self
     */
    public function setOAuth2Server(\Closure $oAuth2Server)
    {
        $this->oAuth2Server = $oAuth2Server();
    }

    /**
     * Authorize token
     *
     * @param  array $queryParams
     * @return array
     */
    public function auth($queryParams) :array
    {
        $statusCode  = 200;
        $tokenData   = null;
        // check token and validate
        if (isset($queryParams['token'])) {
            $this->getOAuth2Request()->headers['AUTHORIZATION'] = 'Bearer ' . $queryParams['token'];
            $tokenData = $this->getOAuth2Server()->getAccessTokenData($this->getOAuth2Request());
            if (is_null($tokenData)) {
                $statusCode = 401;
            }
        } else {
            $statusCode = 403;
        }

        $response = [
            "statusCode" => $statusCode,
            "tokenData"  => $tokenData
        ];

        return $response;
    }

    /**
     * Response for stream file
     *
     * @param string $filename
     * @param string $attachmentFileName
     * @return \Zend\Http\Response\Stream
     */
    protected function responseStreamFile(\Zend\Http\Response $response, string $attachmentFileName, string $filename)
    {
        $headers  = $response->getHeaders();
        $headers->addHeaderLine('Content-Disposition', 'attachment; filename="' . $attachmentFileName . '"');
        $headers->addHeaderLine('Content-Type', mime_content_type($filename));
        $headers->addHeaderLine('Content-Length', filesize($filename));
        $headers->addHeaderLine('Pragma', 'public'); // HTTP/1
        $stream = new \Zend\Http\Response\Stream;
        $stream->setStatusCode(200);
        $stream->setStream(fopen($filename, 'r'));
        $stream->setStreamName(basename($filename));
        $stream->setHeaders($headers);
        return $stream;
    }
}
