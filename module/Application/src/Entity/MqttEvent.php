<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity
 * @ORM\Table(name="mqtt_event", indexes={@ORM\Index(name="idx_id", columns={"id"}), @ORM\Index(name="idx_datetime", columns={"datetime"}), @ORM\Index(name="idx_topic", columns={"topic"})})
 */
class MqttEvent
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */	
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true, options={"default" : "CURRENT_TIMESTAMP"})
     */
    private $datetime;


    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255, nullable=false)
     */
    private $topic;


    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="text", length=65535, nullable=true)
     */
    private $payload;

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $timestamp
     * @return MqttEvent
     */
    public function setDateTime($timestamp)
    {
        $this->datetime = $timestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     * @return MqttEvent
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     * @return MqttEvent
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }



}
