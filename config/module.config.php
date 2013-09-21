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
            'mail' => 'Application\Mail\Factory',
            'mail_message_config' => 'Application\Mail\Message\ConfigFactory',
            'mail_transport' => 'Application\Mail\Transport\Factory'
        )
    )
);