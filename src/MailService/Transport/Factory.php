<?php

namespace MailService\Transport;

use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Factory implements FactoryInterface
{
    /**
     * @var PluginManager
     */
    private $transportPluginManager;

    public function __construct()
    {
        $this->transportPluginManager = new PluginManager();
    }

    /**
     * Creates a mail transport based off of the configuration at mail->transport.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TransportInterface
     * @throws \RuntimeException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (isset($config['mail']['transport'])) {

            //Check to see if we need to create the path
            if (isset($config['mail']['transport']['options']['path']) && $config['mail']['transport']['name'] == 'file') {
                if (!file_exists($config['mail']['transport']['options']['path'])) {
                    mkdir($config['mail']['transport']['options']['path'], 0777, true);
                }
            }

            /** @var TransportInterface $transport */
            $transport = $this->transportPluginManager->get($config['mail']['transport']['name']);

            if (isset($config['mail']['transport']['options'])) {
                $options = $this->getOptionsObject($transport, $config['mail']['transport']['options']);

                if (method_exists($transport, 'setOptions')) {
                    $transport->setOptions($options);
                } else if (method_exists($transport, 'setParameters')) {
                    $transport->setParameters($options);
                }
            }

            return $transport;
        } else {
            throw new \RuntimeException('Mail transport config not set');
        }
    }

    /**
     * Build an options object suitable for use with the specified transport.
     *
     * Uses the transport's class name and concatenates Options on the end.
     * If the resultant class doesn't exist, just returns the original options object.
     *
     *
     * @param TransportInterface $transport
     * @param array|\Traversable|null $options
     * @return mixed
     */
    private function getOptionsObject($transport, $options)
    {
        $optionsClass = get_class($transport) . 'Options';

        if (class_exists($optionsClass)) {
            return new $optionsClass($options);
        }

        return $options;
    }
}