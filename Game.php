<?php

require "Elements.php";
require "Players.php";

class Game
{
    private array $elements = [];
    private array $winners = [];
    private const MAX_WINS = 2;

    public function __construct()
    {
        $this->setUp();
    }

    public function setUp(): void
    {
        $this->elements =
            [
                1 => $rock = new Elements("rock"),
                2 => $paper = new Elements("paper"),
                3 => $scissors = new Elements("scissors")
            ];
        $rock->addWeakerElements([$scissors]);
        $paper->addWeakerElements([$rock]);
        $scissors->addWeakerElements([$paper]);
    }

    public function setWinners(Players $winner): void
    {
        $this->winners[] = $winner;
    }

    public function newBracket(): array
    {
        return array_splice($this->winners, 0, count($this->winners));
    }

    public function getWinners(): array
    {
        return $this->winners;
    }

    public function start(Players $firstPlayer, Players $secondPlayer): void
    {
        $this->displayElements();
        while ($firstPlayer->getWinCountOfFirstPlayer() < self::MAX_WINS && $secondPlayer->getWinCountOfSecondPlayer() < self::MAX_WINS) {
            if (strpos($firstPlayer->getName(), "CPU") === false) {
                $firstPlayer->setChoice($this->elements[(int)readline("Your choice: ")]);
                $secondPlayer->setChoice($this->elements[$secondPlayer->getRandomChoice()]);
            } else if (strpos($secondPlayer->getName(), "CPU") === false) {
                $secondPlayer->setChoice($this->elements[(int)readline("Your choice: ")]);
                $firstPlayer->setChoice($this->elements[$firstPlayer->getRandomChoice()]);
            } else {
                $firstPlayer->setChoice($this->elements[$firstPlayer->getRandomChoice()]);
                $secondPlayer->setChoice($this->elements[$secondPlayer->getRandomChoice()]);
            }

            if ($firstPlayer->getChoice() === $secondPlayer->getChoice()) {
                $firstPlayer->setMadeChoices($firstPlayer);
                $secondPlayer->setMadeChoices($secondPlayer);

            } else if ($firstPlayer->getChoice()->canWin($secondPlayer->getChoice())) {
                $firstPlayer->setWinsForFirstPlayer();
                $firstPlayer->setMadeChoices($firstPlayer);
                $secondPlayer->setMadeChoices($secondPlayer);

            } else {
                $secondPlayer->setWinsForSecondPlayer();
                $firstPlayer->setMadeChoices($firstPlayer);
                $secondPlayer->setMadeChoices($secondPlayer);
            }
        }
        if ($firstPlayer->getWinCountOfFirstPlayer() == 2) {
            $this->setWinners($firstPlayer);
        } else {
            $this->setWinners($secondPlayer);
        }
        echo "==================================" . PHP_EOL;
        echo $firstPlayer->getName() . " chose " . $firstPlayer->getMadeChoices() . PHP_EOL;
        echo $secondPlayer->getName() . " chose " . $secondPlayer->getMadeChoices() . PHP_EOL;
        echo "{$firstPlayer->getName()} ({$firstPlayer->getWinCountOfFirstPlayer()}) : {$secondPlayer->getName()} ({$secondPlayer->getWinCountOfSecondPlayer()})" . PHP_EOL;
        echo "==================================" . PHP_EOL;
        $firstPlayer->clearPoints();
        $secondPlayer->clearPoints();
        $firstPlayer->clearChoices();
        $secondPlayer->clearChoices();

    }

    private function displayElements(): void
    {
        foreach ($this->elements as $key => $element) {
            echo "$key - {$element->getElement()}" . PHP_EOL;
        }
    }
}

