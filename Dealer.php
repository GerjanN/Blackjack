<?php

class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck;
    private array $players = [];
    private Player $dealer;

    public function __construct(Blackjack $blackjack, Deck $deck)
    {
        $this->blackjack = $blackjack;
        $this->deck = $deck;
        $this->addPlayer(new Player('Dealer'));
    }

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function playGame()
    {

        foreach ($this->players as $player) {
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
        }

        foreach ($this->players as $player) {
            $player->setMessage($this->blackjack->scoreHand($player)) . PHP_EOL;
            $message = $player->getMessage();
            if (trim($message) === "Blackjack!") {
                echo $player->getName() . " heeft een Blackjack!" . PHP_EOL;
                foreach ($this->players as $player) {
                    echo $player->showHand($this->blackjack) . PHP_EOL;
                }
                exit;
            }
        }


        while (true) {
            foreach ($this->players as $player) {
                $player->setMessage($player->showHand($this->blackjack)) . PHP_EOL;
                $message = $player->getMessage();

                if (!$player->isActive()) {
                    continue;
                }

                echo $player->showHand($this->blackjack) . PHP_EOL;

                if ($player->getName() === 'Dealer') {
                    $this->dealer = $player;
                    if ($this->dealer->getScore() < 18) {
                        $this->dealer->addCard($this->deck->drawCard());
                        $drawnCard = $this->dealer->getLastCard();
                        echo $this->dealer->getName() . ' heeft een ' . $drawnCard->show() . ' getrokken.' . PHP_EOL;
                        $this->dealer->setMessage($player->showHand($this->blackjack)) . PHP_EOL;
                        $message = $this->dealer->getMessage();
                    } else {
                        echo "Dealer past." . PHP_EOL;
                        $player->setActive(false);
                    }
                } else {
                    echo $player->getName() . " is aan de beurt." . PHP_EOL;


                    $wronginput = true;
                    while ($wronginput) {
                        echo "Wil je nog een kaart? (d/s)" . PHP_EOL;
                        $playeranswer = readline();
                        if ($playeranswer !== "d" && $playeranswer !== "s") {
                            echo "Ongeldige invoer. Typ 'd' om een kaart te trekken of 's' om te passen." . PHP_EOL;
                        } else {
                            $wronginput = false;
                        }
                    }
                    if ($playeranswer === "d") {
                        $player->addCard($this->deck->drawCard());
                        $drawnCard = $player->getLastCard();
                        echo $player->getName() . ' heeft een ' . $drawnCard->show() . ' getrokken.' . PHP_EOL;
                        $player->setMessage($player->showHand($this->blackjack)) . PHP_EOL;
                        $message = $player->getMessage();
                        echo $message . PHP_EOL;
                    } elseif ($playeranswer === "s") {
                        $player->setActive(false);
                        echo "Je hebt gepast." . PHP_EOL;
                    }
                }
            }

            if ($message === "Busted!" || $message === "Twenty One!" || $message === "Five Hand Charlie!") {
                $player->setActive(false);
                continue;
            }
            if (array_reduce($this->players, fn($carry, $player) => $carry && !$player->isActive(), true)) {
                $winner = null;
                $highestScore = 0;

                foreach ($this->players as $player) {
                    echo $player->showHand($this->blackjack) . PHP_EOL;

                    if (trim($player->getMessage()) === "Twenty One!" || trim($player->getMessage()) === "Five Hand Charlie!") {
                        echo $player->getName() . " heeft gewonnen!" . PHP_EOL;
                        return;
                    }

                    $score = $player->getScore();
                    if ($score > $highestScore && $score <= 21) {
                        $highestScore = $score;
                        $winner = $player;
                    }
                }

                if ($winner) {
                    echo $winner->getName() . " heeft gewonnen!" . PHP_EOL;
                } else {
                    echo "De dealer heeft gewonnen!" . PHP_EOL;
                }
                break;
            }
        }
    }
}
