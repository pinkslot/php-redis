<?php

namespace App\Acme\Service\ViewService\Input;

use Symfony\Component\Validator\Constraints as Assert;

class IncreaseViews
{
    /**
     * @var string
     * @Assert\Country
     * @Assert\NotBlank
     */
    private $country;

    public function __construct($country)
    {
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
