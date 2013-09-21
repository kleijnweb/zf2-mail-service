<?php

namespace MailService\Message;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (isset($config['mail']) && isset($config['mail']['message'])) {
            return new Config($config['mail']['message']);
        } else {
            throw new \RuntimeException('Mail message config not set');
        }
    }
}