<?php

class Player
{
    private string $name;
    public array $hand = [];
    public Blackjack $blackjack;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addCard(Card $card)
    {
        $this->hand[] = $card;
    }

    public function showHand(): string
    {
        $hand = [];
        foreach ($this->hand as $card) {
            $hand[] = $card->show();
        }
        return $this->name . " heeft de volgende kaarten in zijn/haar hand: " . implode(" ", $hand) . PHP_EOL;
    }

    public function getScore(): int
    {
        $score = 0;

        foreach ($this->hand as $card) {
            $score += $card->score();
        }

        return $score;
    }

    public function getLastCard() 
    {
        return end($this->hand);
    }
}