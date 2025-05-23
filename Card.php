<?php

class Card
{
    private string $suit;
    private string $value;

    public function __construct($suit, $value)
    {
        if (!$this->validateSuit($suit)) {
            throw new InvalidArgumentException('invalid suit given');
        }
        if (!$this->validateValue($value)) {
            throw new InvalidArgumentException('invalid value given');
        }
        $this->suit = $suit;
        $this->value = $value;
    }

    public function show(): string
    {
        $suit = $this->suit;
        $value = $this->value;
        switch ($suit) {
            case 'Harten':
                $suit = '♥';
                break;
            case 'Ruiten':
                $suit = '♦';
                break;
            case 'Klaver':
                $suit = '♣';
                break;
            case 'Schoppen':
                $suit = '♠';
                break;
            default:
                break;
        }

        switch ($value) {
            case 'Koning':
                $value = 'K';
                break;
            case 'Vrouw':
                $value = 'Q';
                break;
            case 'Boer':
                $value = 'B';
                break;
            case 'Aas':
                $value = 'A';
                break;
            default:
                break;
        }
        return $suit . $value;
    }

    private function validateSuit($suit): bool
    {
        $suits = ['Harten', 'Ruiten', 'Klaver', 'Schoppen'];

        if (in_array($suit, $suits)) {
            return true;
        }
        return false;
    }

    private function validateValue($value): bool
    {
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Boer', 'Vrouw', 'Koning', 'Aas'];
        if (in_array($value, $values)) {
            return true;
        }
        return false;
    }

    public function score(): int
    {
        $value = $this->value;

        switch ($value) {
            case 'Koning':
            case 'Vrouw':
            case 'Boer':
                $value = 10;
                break;
            case 'Aas':
                $value = 11;
                break;
            default:
                $value = intval($value);
        }
        return $value;
    }
}
