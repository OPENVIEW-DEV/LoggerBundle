<?php
namespace Openview\LoggerBundle\Event;
 
use Symfony\Component\EventDispatcher\Event;


/**
 * ActivityEvent class
 */
class ActivityEvent extends Event
{
    const LEVEL_CRITICAL = 0;
    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 3;
    const LEVEL_DEBUG = 4;
    const LEVEL_TRACE = 5;
    const LEVEL_PSYCHO = 10;
    
    // internal use
    protected $container;
    protected $em;
    
    // activity info
    protected $createdAt;
    protected $level;
    protected $ipAddress;
    protected $userId;
    protected $route;
    protected $bundleName;
    protected $controllerName;
    protected $actionName;
    protected $entityId;
    protected $message;
    protected $extraData;
    protected $tag;
    
    
    /**
     * Creates a new instance and populates with the data collected from the action: bundle,
     * controller, action, route, IP address, ...
     * 
     * @param Controller $container
     * @param integer $entityId
     * @param string $message
     * @param integer $level
     */
    public function __construct($container, $entityId=null, $message='', $level=ActivityEvent::LEVEL_INFO) {
        //parent::__construct();
        $this->createdAt = new \DateTime();
        $this->container = $container;
        $this->em = $container->getDoctrine()->getManager();
        
        $this->message = $message;
        $this->level = $level;
        $this->ipAddress = $this->container->get('request')->getClientIp();
        if ($this->container->getUser() !== null) {
            $this->userId = $this->container->getUser()->getId();
        }
        $this->route = $this->container->get('request')->get('_route');
        $template = $this->container->getRequest()->attributes->get('_template');
        // template può essere un oggetto oppure una stringa
        if (is_string($template)) {
            $attributes = $this->container->getRequest()->attributes;
            $fullControllerName = $attributes->get('_controller');  // string like "Openview\DiseaseBundle\Controller\CenterController::createAction"
            $pieces = explode('\\', $fullControllerName);
            if (array_key_exists(0, $pieces)) {
                $this->bundleName = $pieces[0];
            }
            if (array_key_exists(1, $pieces)) {
                $this->bundleName .= '\\' . $pieces[1];
            }
            $otherPieces = explode('::', $pieces[count($pieces)-1]);
            if (count($otherPieces) == 2) {
                $this->controllerName = $otherPieces[0];
                $this->actionName = $otherPieces[1];
            }
        } else {
            $this->bundleName = $template->get('bundle');
            $this->controllerName = $template->get('controller');
            $this->actionName = $_template->get('name');
        }
        $this->entityId = $entityId;
        $this->tag = '';
    }
    
    
    
    function getContainer() {
        return $this->container;
    }

    function getEm() {
        return $this->em;
    }

    function getCreatedAt() {
        return $this->createdAt;
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

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
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