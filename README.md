# LoggerBundle
Bundle to log on a database table application's activities

The following info are stored:
- createdAt: event time (auto-generated)
- level: log level
- ipAddress: origin IPv4 address (auto-generated)
- userId: logged user id (auto-generated, NULL if no user is logged)
- route: current route (auto-generated)
- bundleName: current bundle name (auto-generated)
- controllerName: current controller name (auto-generated)
- actionName: current controller action name (auto-generated)
- entityId: entity involved in the action
- message: your text message
- extraData: some extra data. use setExtraData() method to set it
- tag: a custom tag
- requestMethod: request method (auto-generated)
- requestUri: request full URI (auto-generated)
- requestData: request data serialization (auto-generated) (*beware, for now a file is serialized too*, could be huge)


## Installation

Install with composer:

    # composer.json
    "openview/logger-bundle": "~1.3@dev"
    
Activate the bundle in AppKernel.php

    #AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Openview\LoggerBundle\OpenviewLoggerBundle(),

Update doctrine schema:

    php app/console doctrine:schema:update --force

Import bundle's services.yml:

    #config.yml
    imports:
        - { resource: "@OpenviewLoggerBundle/Resources/config/services.yml" }

To check the service existance, use this console command:

    $ php app/console debug:event-dispatcher ov_logger.logactivity

## Usage

In a controller, import the custom event and dispatch it in thwe actions you want to log

    # Openview\UserBundle\Controller\UserController
    use Openview\LoggerBundle\Event\ActivityEvent;
    ...
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 
                        $this->get('translator')->trans('alert.createok'));
            
            // log event
            $event = new ActivityEvent($this, $id);
            $event->setExtraData($someSerializedExtraData);  // not mandatory
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch('ov_logger.logactivity', $event);

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('warning', 
                        $this->get('translator')->trans('alert.invaliddata'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


### Constructor parameters

    public function __construct($container, $entityId=null, $message='', $level=ActivityEvent::LEVEL_INFO)

$container: the controller
$entityId: the entity involved in the action. Not linked with any foreign key, just the plain code
$message: a message you could want to add
$level: log level

### Log Levels

Log levels usage are up to you. If not set, default log level is INFO

    const LEVEL_CRITICAL = 0;
    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 3;
    const LEVEL_DEBUG = 4;
    const LEVEL_TRACE = 5;
    const LEVEL_PSYCHO = 10;
