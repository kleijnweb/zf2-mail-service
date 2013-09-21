<?php

namespace MailService\Mail\Message;


use Traversable;
use Zend\Stdlib\AbstractOptions;

/**
 * Class Config
 * @package Application\Mail\Message
 *
 * Object used to configure email messages
 */
class Config extends AbstractOptions
{
    /**
     * Sets the FROM address for the email message.
     * @var string
     */
    private $from;

    /**
     * Sets the FROM name to be displayed
     * @var string
     */
    private $fromName;

    /**
     * @inheritdoc
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }
}