<?php

class Player
{
    private string $name;
    public array $hand = [];
    private string $message = "";

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addCard(Card $card)
    {
        $this->hand[] = $card;
    }

    public function showHand(Blackjack $blackjack): string
    {
        $hand = [];
        foreach ($this->hand as $card) {
            $hand[] = $card->show();
        }
        $scoreMessage = $blackjack->scoreHand($this);
        return $this->name . " has " . implode(" ", $hand) . " -> " . $scoreMessage;
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

    private $active = true;

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
