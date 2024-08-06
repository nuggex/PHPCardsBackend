<?php

enum Suit: string
{
    case Hearts = "H";
    case Diamonds = "D";
    case Clubs = "C";
    case Spades = "S";

    public function color(): string{
        return match($this){
            Suit::Hearts, Suit::Diamonds => 'Red',
            Suit::Clubs, Suit::Spades => 'Black'
        };
    }
}
