<?php

namespace App\Entity;

use DateTime;

class Rates
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $rates;

    /**
     * @var DateTime
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->createdAt->setTime(0, 0);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRates(): array
    {
        return $this->rates;
    }

    public function setRates(array $rates)
    {
        $this->rates = $rates;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
