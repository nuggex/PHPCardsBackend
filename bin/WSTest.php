<?php

require_once dirname(__FILE__, 2) . '/autoloader.php';

$server = new OpenSwoole\Websocket\Server("127.0.0.1", 9502);

$players = [];

$server->on('open', function ($server, $req) {
  global $players;
  echo "connection open: {$req->fd}\n";
  foreach ($server->connections as $fd) {
    $connectionInfo = $server->getClientInfo($fd);
    echo "FD: $fd, IP: {$connectionInfo['remote_ip']}, Port: {$connectionInfo['remote_port']}\n";
  }
});

$server->on('message', function ($server, $frame) {
  echo "received message: {$frame->data}\n";
  $data = json_decode($frame->data);

  if ($data->msg === "START") {

    // TODO: We probably need some DB to store the game state in, sqlite or something else
    // TODO: Create starting game state 

    foreach ($server->connections as $playerId) {

      $response = [
        "type" => "INIT_GAME",
        "gameType" => "PASKAHOUSU",
        "deck" => [
          // A Deck of hidden cards
        ],
        "cardsOnTable" => [
          // A Deck of visible cards
        ],
        "otherPlayers" => [
          // This should maybe be a list of Players instances
          [
            "playerId" => 42,
            "cardsInHand" => ["?", "?", "?"]
          ]
        ],
        "currentPlayer" =>
        // This should maybe be a instance of a Player class 
        [
          "playerId" => $playerId,
          "cardsInHand" => ["A1", "H7", "D10"]
        ]

      ];
      $server->push($playerId, json_encode($response));
    }
  }
  if ($data->msg === "END_ROUND") {
    $playerWhoseTurnItIs = $data->currentPlayerId;
    $selectedCards = $data->selectedCards;

    // TODO: Do some game logic with the cards the player selected so we get the new state of the game

    // TODO: if a player won the game do some game ending thing  

    foreach ($server->connections as $playerId) {
      // TODO: Send the new deck state, cardsOnTable, otherPlayers and currentPlayer 
      // currentPlayer state data based on the playerId 

      $response = [
        "type" => "NEXT_ROUND",
        "deck" => [],
        "cardsOnTable" => [],
        "otherPlayers" => [
          []
        ],
        "currentPlayer" =>
        [
          "playerId" => $playerId,
          "cardsInHand" => ["A1", "H7", "D10"]
        ]
      ];
      $server->push($playerId, json_encode($response));
    }
  }
});

$server->on('close', function ($server, $fd) {
  echo "connection close: {$fd}\n";
});

$server->start();
echo "started";
