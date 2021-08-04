<?php
namespace Framework\Router;

/**
 * Class Route
 * 
 * match des routes
 */
class Route {

    /**
     * @var string
     */
    private string $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var array
     */
    private array $array;


    public function __construct(string $name, callable $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * Undocumented function
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * Retourne la liste des paramettres
     *
     * @return string[]
     */
    public function getParams():array
    {
        return $this->parameters;
    }

}
