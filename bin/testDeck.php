<?php

require_once dirname(__FILE__, 2) . '/autoloader.php';

$deck = new Deck();


$players = 3;
$cardsPerHand = 5;
$hands = array();
for($i = 0; $i < $players; $i++)
    $hands[] = new Hand();
for ($i = 0; $i < $cardsPerHand; $i++) {
    for ($j = 0; $j < $players; $j++) {
        $card = array_splice($deck->Deck, 0,1);
        $hands[$j]->addCard(reset($card));
    }
}

var_dump($hands);
//print_r($deck);