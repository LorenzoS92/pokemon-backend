<?php

namespace App\Services;

class PokemonApi
{
    protected int $id;
    protected string $name;
    protected string $sprite;

    /**
     * @param int $id ID of the pokemon from PokeApi
     * @param string $name name of the pokemon from PokeAPI
     * @param string $sprite sprite URL image of the pokemon fron PokeAPI
     */
    public function __construct(int $id, string $name, string $sprite)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sprite = $sprite;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSprite(): string
    {
        return $this->sprite;
    }
}
