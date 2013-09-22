<?php

namespace MailService\Test\Message;


use MailService\Message\Config;
use MailService\Message\ConfigFactory;
use Zend\ServiceManager\ServiceManager;

class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $config = array(
            'mail' => array (
                'message' => array (
                    'from' => 'test@example.com',
                )
            )
        );

        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', $config);

        $factory = new ConfigFactory();
        /** @var Config $messageConfig */
        $messageConfig = $factory->createService($serviceManager);

        $this->assertInstanceOf('MailService\Message\Config', $messageConfig);
        $this->assertEquals($config['mail']['message']['from'], $messageConfig->getFrom());
    }
}
