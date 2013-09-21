zf2-mail-service
================

A configurable service for Zend\Mail


Configuration
---------
Configure your mail settings using the `mail` configuration key.

    return array (
        'mail' => array (
            'message' => array (
                'from' => 'no-reply@localhost',
                'from_name' => 'localhost'
            ),

            'transport' => array (
                'name' => 'file',
                'options' => array (
                    'path' => 'data/mail'
                )
            )
    ));


SMTP Configuration Example:

    return array (
        'mail' => array (
            'message' => array (
                'from' => 'no-reply@ethicaladdiction.com',
                'from_name' => 'Ethical Addiction'
            ),

            'transport' => array (
                'name' => 'smtp',
                'options' => array (
                    'name' => 'gmail.com',
                    'host' => 'smtp.gmail.com',
                    'port'              => 465,
                    'connection_class' => 'login',
                    'connection_config' => array (
                        'ssl' => 'ssl',
                        'username' => 'no-reply@gmail.com',
                        'password' => 'no-reply-password'
                    )
                )
            )
        )
    );

Usage
-----

    $mailFactory = $this->getServiceLocator()->get('mail');

    $viewModel = new ViewModel(array(
        'foo' => 'bar'
    ));
    $viewModel->setTemplate('_mail/text/message.phtml');

    $message = $mailFactory->prepareMessage($viewModel);
    $message->setSubject('Test Message');
    $message->setTo('test@example.com');

    $transport = $mailFactory->getTransport();
    $transport->send($message);
