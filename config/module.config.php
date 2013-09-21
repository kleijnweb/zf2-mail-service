<?php

return array(
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
    ),

    'service_manager' => array (
        'factories' => array (
            'mail' => 'MailService\Factory',
            'mail_message_config' => 'MailService\Message\ConfigFactory',
            'mail_transport' => 'MailService\Transport\Factory'
        )
    )
);