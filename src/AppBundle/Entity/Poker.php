<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poker
 *
 * @ORM\Table(name="poker")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PokerRepository")
 */
class Poker
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $room;

    /**
     * @ORM\Column(name="choice", type="string", length=100)
     * @var string
     */
    private $choice;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $choiceDigit;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * @param mixed $choice
     */
    public function setChoice($choice)
    {
        $this->choice = $choice;
    }

    /**
     * @return string
     */
    public function getChoiceDigit()
    {
        return $this->choiceDigit;
    }

    /**
     * @param mixed $choiceDigit
     */
    public function setChoiceDigit($choiceDigit)
    {
        $this->choiceDigit = $choiceDigit;
    }

}

