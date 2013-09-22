<?php

namespace MailService\Test\Transport;


use MailService\Transport\Factory as TransportFactory;
use Zend\ServiceManager\ServiceManager;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testFile()
    {
        $config = array(
            'mail' => array (
                'transport' => array (
                    'name' => 'file',
                    'options' => array (
                        'path' => sys_get_temp_dir()
                    )
                )
            )
        );

        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', $config);

        $factory = new TransportFactory();

        /** @var \Zend\Mail\Transport\File $service */
        $service = $factory->createService($serviceManager);
        $this->assertInstanceOf('Zend\Mail\Transport\File', $service);

        $serviceConfig = $this->readAttribute($service, 'options');
        $this->assertEquals($config['mail']['transport']['options']['path'], $serviceConfig->getPath());

    }
}
