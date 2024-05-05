<?php

namespace Xtend\Apns\Adapter;

use Symfony\Component\Process\ProcessBuilder;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Xtend\Notification\Adapter\AdapterInterface;

class Cli implements AdapterInterface
{
    use LoggerAwareTrait;

    protected $phpProcessBuilder;

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

    /**
     * Send
     *
     * @param string $deviceToken
     * @param \Xtend\Notification\Message $message
     */
    public function send($deviceToken, \Xtend\Notification\MessageInterface $message)
    {
        $cli = $this->getPhpProcessBuilder()
                    ->setArguments(
                        ['apns', 'send', $deviceToken, '"' . addslashes($message->__toString()) . '"']
                    )->getProcess();
        $cli->start();
        $pid = $cli->getPid();
        $this->logger->log(
            LogLevel::INFO,
            "{function} {pid} {commandline}",
            ["function" => __FUNCTION__, "commandline" => $cli->getCommandLine(), "pid" => $pid]
        );
    }
}
