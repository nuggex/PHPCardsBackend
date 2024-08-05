<?php

class Card
{

    public Value $value;
    public Suit $suit;

    public function __construct($suit, $value)
    {
        $this->value = $value;
        $this->suit = $suit;
    }
}
