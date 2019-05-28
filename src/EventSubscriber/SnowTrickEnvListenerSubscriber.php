<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 10/04/19
 * Time: 16:31
 */

namespace App\EventSubscriber;

// for Doctrine < 2.4: use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use App\Service\Configuration;
class SnowTrickEnvListenerSubscriber implements EventSubscriberInterface
{

    protected $twig;
    protected $config;

    public function __construct(\Twig_Environment $twig, Configuration $configuration)
    {
        $this->twig = $twig;
        $this->config = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -128],
            KernelEvents::VIEW => 'onKernelView',
        ];
    }

    public function onKernelController(FilterControllerEvent $event,  $d)
    {


     $this->twig->addGlobal('footercopyright',  $this->config->get("FOOTERCOPYRIGHT", ''));

        $this->twig->addGlobal('footertwitterurl',  $this->config->get("FOOTERTWITTERURL", ''));
        $this->twig->addGlobal('footeryoutubeurl',  $this->config->get("FOOTERYOUTUBEURL", ''));
        $this->twig->addGlobal('footerfacebookurl',  $this->config->get("FOOTERFACEBOOKURL", ''));

        // dump($this->twig );
       // die("g");
    }

}