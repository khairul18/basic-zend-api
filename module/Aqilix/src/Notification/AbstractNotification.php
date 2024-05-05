<?php
/**
 * Abstract Notification
 *
 * @link
 * @copyright Copyright (c) 2017
 */

namespace Aqilix\Notification;

use Symfony\Component\Process\ProcessBuilder;

class AbstractNotification
{
    protected $config;

    protected $phpProcessBuilder;

    /**
     * Construct Event
     *
     * @param ProcessBuilder $phpProcessBuilder
     */
    public function __construct(ProcessBuilder $phpProcessBuilder)
    {
        $this->setPhpProcessBuilder($phpProcessBuilder);
    }

    /**
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param field_type $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Get ProcessBuilder
     *
     * @return ProcessBuilder $phpProcessBuilder
     */
    public function getPhpProcessBuilder()
    {
        return $this->phpProcessBuilder;
    }

    /**
     * @param ProcessBuilder $phpProcessBuilder
     */
    public function setPhpProcessBuilder(ProcessBuilder $phpProcessBuilder)
    {
        $this->phpProcessBuilder = $phpProcessBuilder;
    }
}
