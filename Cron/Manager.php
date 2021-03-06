<?php

namespace Cron\CronBundle\Cron;

use Cron\CronBundle\Entity\CronJob;
use Cron\CronBundle\Entity\CronJobRepository;
use Cron\CronBundle\Entity\CronReport;
use Symfony\Bridge\Doctrine\RegistryInterface;


class Manager
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @param RegistryInterface $registry
     */
    function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return CronJobRepository
     */
    protected function getJobRepo()
    {
        return $this->registry->getRepository('CronCronBundle:CronJob');
    }

    /**
     * @param CronReport[] $reports
     */
    public function saveReports(array $reports)
    {
        $em = $this->registry->getManager();
        foreach ($reports as $report) {
            $dbReport = new CronReport();
            $dbReport->setJob($report->getJob()->raw);
            $dbReport->setOutput(implode("\n", (array) $report->getOutput()));
            $dbReport->setExitCode($report->getJob()->getProcess()->getExitCode());
            $dbReport->setRunAt(\DateTime::createFromFormat('U.u', (string) $report->getStartTime()));
            $dbReport->setRunTime($report->getEndTime() - $report->getStartTime());
            $em->persist($dbReport);
        }
        $em->flush();
    }

    /**
     * @return CronJob[]
     */
    public function listJobs()
    {
        return $this->getJobRepo()
            ->findBy(array(), array(
                    'name' => 'asc',
                ));
    }

    /**
     * @return CronJob[]
     */
    public function listEnabledJobs()
    {
        return $this->getJobRepo()
            ->findBy(array(
                    'enabled' => 1,
                ), array(
                    'name' => 'asc',
                ));
    }

    /**
     * @param CronJob $job
     */
    public function saveJob(CronJob $job)
    {
        $em = $this->registry->getManager();
        $em->persist($job);
        $em->flush();
    }

    /**
     * @param  string  $name
     * @return CronJob
     */
    public function getJobByName($name)
    {
        return $this->getJobRepo()
            ->findOneBy(array(
                    'name' => $name,
                ));
    }

    /**
     * @param CronJob $job
     */
    public function deleteJob(CronJob $job)
    {
        $em = $this->registry->getManager();
        $em->remove($job);
        $em->flush();
    }
}
