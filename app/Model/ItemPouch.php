<?php


namespace MHFSaveManager\Model;


class ItemPouch
{
    protected $items = [];
    
    public function addItem(Item $item, int $slot)
    {
        if (isset($this->items[$slot])) {
            return false;
        }
        
        $this->items[$slot] = $item;
        
        return true;
    }
    
    public function removeItem(string $slot)
    {
        if (!isset($this->items[$slot])) {
            return false;
        }
        
        unset($this->items[$slot]);
        
        return true;
    }
    
    public function setItemQuantity(string $slot, int $quantity)
    {
        if (!isset($this->items[$slot])) {
            return false;
        }
        
        $this->items[$slot]->setQuantity($quantity);
    }
}
