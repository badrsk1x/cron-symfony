<?php

namespace Cron\CronBundle\Cron;

use Symfony\Component\Process\PhpExecutableFinder;


class CommandBuilder
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $phpExecutable;

    /**
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;

        $finder = new PhpExecutableFinder();
        $this->phpExecutable = $finder->find();
    }

    /**
     * @param string $command
     *
     * @return string
     */
    public function build($command)
    {
        return sprintf('%s %s %s --env=%s', $this->phpExecutable, $_SERVER['SCRIPT_NAME'], $command, $this->environment);
    }
}
