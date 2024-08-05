<?php

class Deck
{
    public array $Deck;

    public function __construct(array $skipValues = [])
    {
        foreach (Suit::cases() as $suit) {
            foreach (Value::cases() as $value) {
                if (!in_array($value, $skipValues)) {
                    $card = new Card($suit, $value);
                    $this->Deck[] = $card;
                }
            }
        }
        $this->Shuffle();
    }

    public function Shuffle(): void
    {
        $this->Wash();
        for ($i = 0; $i < 3; $i++)
            $this->Riffle();
        $this->OverHand();
        $this->Riffle();
        $this->Cut();
    }

    private function Wash(): void
    {
        $numCards = count($this->Deck);
        $times = rand(3, 7);
        for ($i = 0; $i < $times; $i++) {
            for ($j = 0; $j < $numCards; $j++) {
                $randomIndex = rand(0, $numCards - 1);
                $temp = $this->Deck[$j];
                $this->Deck[$j] = $this->Deck[$randomIndex];
                $this->Deck[$randomIndex] = $temp;
            }
        }
    }

    private function Riffle(): void
    {
        $half = intval(count($this->Deck) / 2);
        $left = array_slice($this->Deck, 0, $half);
        $right = array_slice($this->Deck, $half);

        $shuffledDeck = array();
        while (!empty($left) || !empty($right)) {
            if (!empty($left)) {
                $shuffledDeck[] = array_shift($left);
            }
            if (!empty($right)) {
                $shuffledDeck[] = array_shift($right);
            }
        }

        $this->Deck = $shuffledDeck;

    }

    private function OverHand(): void
    {
        $shuffledDeck = [];
        while (!empty($this->Deck)) {
            $chunkSize = rand(1, 5);
            $chunk = array_splice($this->Deck, 0, $chunkSize);
            $shuffledDeck = array_merge($chunk, $shuffledDeck);
        }
        $this->Deck = $shuffledDeck;
    }

    private function Cut(): void
    {
        $cutPoint = rand(10, count($this->Deck) - 10);
        $top = array_slice($this->Deck, 0, $cutPoint);
        $bottom = array_slice($this->Deck, $cutPoint);
        $this->Deck = array_merge($bottom, $top);
    }

    public function Deal()
    {

    }

    public function DrawTop()
    {
        return array_splice($this->Deck, 0, 1);

    }

    public function BurnTop()
    {
        array_splice($this->Deck, 0, 1);
        return null;
    }

    public function PutCardOnTop($card)
    {
        $top = array($card);
        $this->Deck = array_merge($top, $this->Deck);

    }

    public function PutCardOnBottom($card)
    {
        $bottom = array($card);
        $this->Deck = array_merge($this->Deck, $bottom);
    }

}