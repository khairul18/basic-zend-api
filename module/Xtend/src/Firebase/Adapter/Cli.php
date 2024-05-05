<?php

namespace Xtend\Firebase\Adapter;

use Symfony\Component\Process\ProcessBuilder;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;

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
     * @param string $firebaseId
     * @param \Xtend\Notification\MessageInterface $message
     */
    public function send($firebaseId, \Xtend\Notification\MessageInterface $message)
    {
        $cli = $this->getPhpProcessBuilder()
                    ->setArguments(
                        ['firebase', 'send', $firebaseId, '"' . addslashes($message->__toString()) . '"']
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
