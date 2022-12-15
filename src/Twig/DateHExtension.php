<?php

use Twig\TwigFunction;

class DateHExtension extends \Twig\Extension\AbstractExtension
{
    /*public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }*/
    public function getFunctions(): array
    {
        return [
            new TwigFunction('dateH', [$this, 'dateH']),
        ];
    }
    public function dateH(DateTime $date)
    {
        $dateH = $date->format("d/m/Y")." à ".$date->format("h:i");

        return $dateH;
    }
}