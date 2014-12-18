<?php
namespace Openview\LoggerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Openview\LoggerBundle\Event\ActivityEvent;

/**
 * Stores the activity log entries
 * 
 * @ORM\Entity
 * @ORM\Table(name="log_activity")
 */
class ActivityLog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $level;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ipAddress;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $userId;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $route;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bundleName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $controllerName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $actionName;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $entityId;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $message;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extraData;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tag;

    
    
    /**
     * Data is copied from the ActivityEvent
     * 
     * @param ActivityEvent $event
     */
    public function __construct(ActivityEvent $event) {
        $this->createdAt = $event->getCreatedAt();
        $this->level = $event->getLevel();
        $this->ipAddress = $event->getIpAddress();
        $this->userId = $event->getUserId();
        $this->route = $event->getRoute();
        $this->bundleName = $event->getBundleName();
        $this->controllerName = $event->getControllerName();
        $this->actionName = $event->getActionName();
        $this->entityId = $event->getEntityId();
        $this->message = $event->getMessage();
        $this->extraData = $event->getExtraData();
        $this->tag = $event->getTag();
    }
    

    function getId() {
        return $this->id;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function getLevel() {
        return $this->level;
    }

    function getIpAddress() {
        return $this->ipAddress;
    }

    function getUserId() {
        return $this->userId;
    }

    function getRoute() {
        return $this->route;
    }

    function getBundleName() {
        return $this->bundleName;
    }

    function getActionName() {
        return $this->actionName;
    }

    function getEntityId() {
        return $this->entityId;
    }

    function getMessage() {
        return $this->message;
    }

    function getExtraData() {
        return $this->extraData;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function setIpAddress($ipAddress) {
        $this->ipAddress = $ipAddress;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setRoute($route) {
        $this->route = $route;
    }

    function setBundleName($bundleName) {
        $this->bundleName = $bundleName;
    }

    function setActionName($actionName) {
        $this->actionName = $actionName;
    }

    function setEntityId($entityId) {
        $this->entityId = $entityId;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setExtraData($extraData) {
        $this->extraData = $extraData;
    }
    
    function getControllerName() {
        return $this->controllerName;
    }

    function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }
    
    function getTag() {
        return $this->tag;
    }

    function setTag($tag) {
        $this->tag = $tag;
    }


}