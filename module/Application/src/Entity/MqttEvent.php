<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity
 * @ORM\Table(name="mqtt_event", indexes={@ORM\Index(name="idx_timestamp", columns={"timestamp"}), @ORM\Index(name="idx_topic", columns={"topic"})})
 */
class MqttEvent
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;


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
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     * @return MqttEvent
     */
    public function setTimestamp($timestamp)
    {
        if(isset($timestamp)){
            if(is_string($timestamp)){
                $timestamp = \DateTime::createFromFormat('H:i:s',trim($timestamp));
            }
        }
        $this->timestamp = $timestamp;
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