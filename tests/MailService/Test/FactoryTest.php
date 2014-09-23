<?php

namespace MailService\Test;


use MailService\Transport\Factory as TransportFactory;
use Zend\ServiceManager\ServiceManager;
use MailService\Message\Config;
use MailService\Message\ConfigFactory;
use MailService\Factory as MessageFactory;
use Zend\View\Model\ViewModel;
use Zend\Mime\Message as MimeMessage;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider configProvider
     */
    public function emailHasHtmlMimePart($messageConfig)
    {
        $renderer = $this->getMockBuilder('Zend\View\Renderer\PhpRenderer')->disableOriginalConstructor()->getMock();

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')->disableOriginalConstructor()->getMock();

        $map = [
            'ViewRenderer' => $renderer,
            'mail_message_config' => $messageConfig
        ];
        $serviceManager
            ->expects($this->any())
            ->method($this->equalTo('get'))
            ->will($this->returnCallback(function ($key) use($map) {
                return $map[$key];
            }));

        $factory = new MessageFactory();
        $factory->createService($serviceManager);
        $message = $factory->prepareMessage(new ViewModel());
        /** @var MimeMessage $actual */
        $actual = $message->getBody();
        $actualParts = $actual->getParts();
        $this->assertInstanceOf('Zend\Mime\Part', $actualParts[0]);
    }

    /**
     * @return Config
     */
    public static function configProvider()
    {
        $config = array(
            'mail' => array(
                'message' => array(
                    'from' => 'test@example.com',
                )
            )
        );

        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', $config);

        $factory = new ConfigFactory();
        /** @var Config $messageConfig */
        $messageConfig = $factory->createService($serviceManager);

        return [[$messageConfig]];
    }
}
