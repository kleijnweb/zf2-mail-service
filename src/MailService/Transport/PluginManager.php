<?php

namespace MailService\Transport;


use Zend\Mail\Exception\RuntimeException;
use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class PluginManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
        'file' => 'Zend\Mail\Transport\File',
        'sendmail' => 'Zend\Mail\Transport\Sendmail',
        'smtp' => 'Zend\Mail\Transport\Smtp',
    );

    /**
     * @inheritdoc
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof TransportInterface){
            return;
        }

        throw new RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement Zend\Mail\Transport\TransportInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }
}