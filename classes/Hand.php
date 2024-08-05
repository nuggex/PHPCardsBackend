<?php

class Hand
{

    private array $cards;
    private array $publicCards;

    public function __construct()
    {

    }
    public function addCard($card){
        $this->cards[] = $card;
    }
}