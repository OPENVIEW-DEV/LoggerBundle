<?php
namespace Openview\LoggerBundle\Listener;

use Openview\LoggerBundle\Event\ActivityEvent;
use Openview\LoggerBundle\Entity\ActivityLog;

/**
 * Listen the ActivityEvent events and persists the in database
 */
class ActivityListener
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /** 
     * At start, ensures Entity Manager is NULL
     */
    public function __construct() {
        $this->em = null;
    }
    
    
    /**
     * When catches an ActivityEvent, persists it
     * 
     * @param ActivityEvent $event
     */
    public function onActivityEvent(ActivityEvent $event) {
        // set EM only if it's not been set before
        if ($this->em === null) {
            $this->em = $event->getEm();
        }
        
        // create a new log, based on the event
        $log = new ActivityLog($event);
        // persists it
        $this->em->persist($log);
        $this->em->flush();
    }
}