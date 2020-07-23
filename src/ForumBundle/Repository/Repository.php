<?php
namespace ForumBundle\Repository;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class Repository
 * @package ForumBundle\Repository
 */

abstract class Repository extends EntityRepository
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}