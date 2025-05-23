<?php

class Blackjack
{
    public Player $player;
    public Deck $deck;

    public function scoreHand(Player $player): string
    {
        $score = $player->getScore();
        if ($score > 21) {
            $player->setActive(false);
            return "Busted!" . PHP_EOL;
        } elseif (count($player->hand) === 5 && $score < 21) {
            $player->setActive(false);
            return "Five Hand Charlie!" . PHP_EOL;
        } elseif (count($player->hand) === 2 && $score === 21) {
            $player->setActive(false);
            return "Blackjack!" . PHP_EOL;
        } elseif ($score === 21) {
            $player->setActive(false);
            return "Twenty One!" . PHP_EOL;
        } else {
            return $score . PHP_EOL;
        }
    }
}
