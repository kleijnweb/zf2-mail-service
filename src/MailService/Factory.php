<?php

namespace MailService;


use MailService\Mail\Message\Config as MessageConfig;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class Factory implements FactoryInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * Gets a mail message with some of the fields populated.
     * @return Message
     */
    public function getMessage()
    {
        /** @var MessageConfig $messageConfig */
        $messageConfig = $this->serviceLocator->get('mail_message_config');

        $mail = new Message();
        $mail->setFrom($messageConfig->getFrom(), $messageConfig->getFromName());

        return $mail;
    }

    /**
     * Gets the configured mail transport.
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->serviceLocator->get('mail_transport');
    }

    /**
     * Prepares the message for sending by rendering the view.
     *
     * @param ViewModel $viewModel
     * @return \Zend\Mail\Message
     */
    public function prepareMessage(ViewModel $viewModel)
    {
        /** @var PhpRenderer $viewRenderer */
        $viewRenderer = $this->serviceLocator->get('ViewRenderer');
        $result = $viewRenderer->render($viewModel);


        $message = $this->getMessage();
        $message->setBody($result);

        return $message;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return $this
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }
}