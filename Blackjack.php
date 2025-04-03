<?php

class Blackjack
{
    public Player $player;
    public Deck $deck;

    public function __construct(Player $player)
    {
        $this->deck = new Deck();
        $this->player = $player;
        $this->player->addCard($this->deck->drawCard());
        $this->player->addCard($this->deck->drawCard());
    }

    public function scoreHand(): string
    {
        $score = $this->player->getScore();
        if ($score > 21) {
            return "Busted!";
        } elseif (count($this->player->hand) === 5 && $score < 21) {
            return "Five Hand Charlie!";
        } elseif (count($this->player->hand) === 2 && $score === 21) {
            return "Blackjack!";
        } elseif ($score === 21) {
            return "Twenty One!";
        } else {
            return "Je score is " . $score . PHP_EOL;
        }
    }
}