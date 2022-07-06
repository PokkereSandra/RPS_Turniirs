<?php

require "Game.php";

class Tournament
{
    private array $players;
    private array $winners = [];
    private array $bracketTablePlayers = [];

    public function __construct()
    {
        $this->bracketTablePlayers = $this->registration();
    }

    public function registration(): array
    {
        return $this->players =
            [
                new Players(readline("Enter Your name: ")),
                new Players("CPU 1"),
                new Players("CPU 2"),
                new Players("CPU 3"),
                new Players("CPU 4"),
                new Players("CPU 5"),
                new Players("CPU 6"),
                new Players("CPU 7"),
            ];
    }

    public function getBracketTablePlayers(): array
    {
        return $this->bracketTablePlayers;
    }

    public function setBracketTablePlayers($winners): void
    {
        foreach ($winners as $winner) {
            $this->bracketTablePlayers[] = $winner;
        }
    }

    public function setWinners(array $winners): void
    {
        foreach ($winners as $winner) {
            $this->winners[] = $winner;
        }

    }

    public function getWinners(): array
    {
        return $this->winners;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setPlayers(array $winners): void
    {
        $this->players = $winners;
    }

    public function round(): array
    {
        return array_chunk($this->getPlayers(), 2);
    }

    public function newBracket(): array
    {
        return array_splice($this->winners, 0, count($this->winners));
    }

    public function getScoreBoard()
    {
        echo "|{$this->getBracketTablePlayers()[0]->getName()}|------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[8])) {
            echo "--------      |{$this->getBracketTablePlayers()[8]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[1]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[12])) {
            echo "--------                      |{$this->getBracketTablePlayers()[12]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------                      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[2]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[9])) {
            echo "--------      |{$this->getBracketTablePlayers()[9]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[3]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[14])) {
            echo "--------                                      |{$this->getBracketTablePlayers()[14]->getName()} |" . PHP_EOL;
        } else {
            echo "--------                                      |______|" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[4]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[10])) {
            echo "--------      |{$this->getBracketTablePlayers()[10]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[5]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[13])) {
            echo "--------                      |{$this->getBracketTablePlayers()[13]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------                      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[6]->getName()} |------" . PHP_EOL;
        if (isset($this->getBracketTablePlayers()[11])) {
            echo "--------      |{$this->getBracketTablePlayers()[11]->getName()} | ------" . PHP_EOL;
        } else {
            echo "--------      |______| ------" . PHP_EOL;
        }
        echo "|{$this->getBracketTablePlayers()[7]->getName()} |------" . PHP_EOL;
        echo "--------" . PHP_EOL;

    }

    public function getLeaderBoard(array $players): array
    {
        $fromFirstPlace = array_reverse($players);
        $onlyEight = array_unique($fromFirstPlace, SORT_REGULAR);
        return array_values($onlyEight);
    }

}

$rounds = 3;
$tournament = new Tournament();
$game = new Game;
echo "====Welcome to the tournament of ROCK,PAPER,SCISSORS===" . PHP_EOL;
$tournament->getScoreBoard();
while ($rounds > 0) {
    foreach ($tournament->round() as $bracket) {
        $game->start($bracket[0], $bracket[1]);
    }
    $tournament->setBracketTablePlayers($game->getWinners());
    $tournament->getScoreBoard();
    echo "==================================" . PHP_EOL;
    $tournament->setWinners($game->getWinners());
    $game->newBracket();
    $tournament->setPlayers($tournament->getWinners());
    $tournament->newBracket();
    $rounds--;
}
echo "===Champions of ROCK, PAPER, SCISSORS===" . PHP_EOL;
foreach ($tournament->getLeaderBoard($tournament->getBracketTablePlayers()) as $number => $player) {
    $place = $number + 1;
    echo "# $place - {$player->getName()}" . PHP_EOL;
}

