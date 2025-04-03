<?php

require_once 'Player.php';
require_once 'Deck.php';
require_once 'Card.php';
require_once 'Blackjack.php';

echo 'Welkom bij blackjack! Wat is je naam? ' . PHP_EOL;
$name = readline();
$player = new Player($name);
$blackjack = new Blackjack($player);
echo $player->showHand();
$message = $blackjack->scoreHand();

$input = '';

if ($message === "Blackjack!") {
    echo $message . PHP_EOL;
    exit;
}

while ($message !== "Busted!" && $message !== "Twenty One!" && $message !== "Five Hand Charlie!") {
    echo 'Nieuwe kaart (n) of stoppen (s)?' . PHP_EOL;
    $input = readline();
    if ($input == 'n') {
        $player->addCard($blackjack->deck->drawCard());
        $drawnCard = $player->getLastCard();
        echo 'Je hebt een ' . $drawnCard->show() . ' getrokken.' . PHP_EOL;
    } elseif ($input == 's') {
        break;
    }
    $message = $blackjack->scoreHand();
    echo $message . PHP_EOL;
}

$score = $player->getScore();
echo "Je score is $score" . PHP_EOL;