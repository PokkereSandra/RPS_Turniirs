<?php

class Players
{
    private string $name;
    private ?Elements $choice = null;
    private int $firstPlayerWinCount = 0;
    private int $secondPlayerWinCount = 0;
    private array $madeChoices = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChoice(): Elements
    {
        return $this->choice;
    }

    public function setChoice(Elements $choice): void
    {
        $this->choice = $choice;
    }

    public function setWinsForFirstPlayer(): void
    {
        $this->firstPlayerWinCount = $this->firstPlayerWinCount + 1;
    }

    public function getWinCountOfFirstPlayer(): int
    {
        return $this->firstPlayerWinCount;
    }

    public function setWinsForSecondPlayer(): void
    {
        $this->secondPlayerWinCount = $this->secondPlayerWinCount + 1;
    }

    public function getWinCountOfSecondPlayer(): int
    {
        return $this->secondPlayerWinCount;
    }

    public function setMadeChoices(Players $player): void
    {
        $this->madeChoices[] = $player->getChoice()->getElement();
    }

    public function getMadeChoices(): string
    {
        return implode(" & ", $this->madeChoices);
    }

    public function clearChoices(): void
    {
        $this->madeChoices = [];
    }

    public function getRandomChoice(): int
    {
        return rand(1, 3);
    }

    public function clearPoints(): void
    {
        $this->firstPlayerWinCount = 0;
        $this->secondPlayerWinCount = 0;
    }
}
