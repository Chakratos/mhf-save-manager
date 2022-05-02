<?php


namespace MHFSaveManager\Model;

use MHFSaveManager\Service\ItemsService;

class Decoration extends Item
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var string
     */
    protected $name;
    
    public function __construct($id)
    {
        $this->id = $id;
        $this->name = ItemsService::$items[strtoupper($this->id)];
        $this->quantity = 1;
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
