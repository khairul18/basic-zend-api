<?php

namespace Xtend\Email\Adapter;

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
     * @param string $to
     * @param Xtend\Email\Message $message
     */
    public function send($to, \Xtend\Notification\MessageInterface $message)
    {
        $cli = $this->getPhpProcessBuilder()
                    ->setArguments(
                        ['notification', $to, '"' . addslashes($message->__toString()) . '"']
                    )->getProcess();
        $cli->run();
        $pid = $cli->getPid();
        $this->logger->log(
            LogLevel::INFO,
            "{function} {pid} {commandline}",
            ["function" => __FUNCTION__, "commandline" => $cli->getCommandLine(), "pid" => $pid]
        );
    }
}
