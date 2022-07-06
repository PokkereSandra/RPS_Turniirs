<?php

class Elements
{
    private string $element;
    private array $weakerElements = [];

    public function __construct($element)
    {
        $this->element = $element;
    }

    public function getElement(): string
    {
        return $this->element;
    }

    public function getWeakerElements(): array
    {
        return $this->weakerElements;
    }

    public function addWeakerElement(Elements $weakerElement): void
    {
        $this->weakerElements[] = $weakerElement;
    }

    public function addWeakerElements(array $weakerElements): void
    {
        foreach ($weakerElements as $weakerElement) {
            if (!$weakerElement instanceof Elements) continue;
            $this->addWeakerElement($weakerElement);
        }
    }

    public function canWin(Elements $weakerElement): bool
    {
        return in_array($weakerElement, $this->getWeakerElements());
    }
}

