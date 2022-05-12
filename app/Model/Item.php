<?php


namespace MHFSaveManager\Model;

use MHFSaveManager\Service\ItemsService;

//Item Box
/*
 * 8 Byte per Item
 * 4 Byte Padding? 00 00 00 00
 * 2 Byte ID
 * 2 Byte Quantity
 */
class Item extends AbstractBinaryModel
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
    
    /**
     * @var int
     */
    protected $slot;
    
    public function __toString()
    {
        return sprintf("['id' => '%s','quantity' => '%s', 'name' => '%s', 'slot' => %s],", $this->id, $this->quantity, $this->name, $this->slot);;
        //return sprintf("%s | %sx %s", $this->id, $this->quantity, $this->name);
    }
    
    public function __construct($binary = null)
    {
        if ($binary == null) {
            return;
        }
        
        $this->binaryString = $binary;
        if (strlen(bin2hex($binary)) == 4) {
            $this->id = strtoupper($this->read(2, false));
            $this->name = ItemsService::$items[strtoupper($this->id)]['name'];
            
            return;
        }
        
        $this->read(4); //Padding?
        $this->id = strtoupper($this->read(2, false));
        $this->name = ItemsService::$items[strtoupper($this->id)]['name'];
        $this->quantity = unpack('v', $this->read(2, true))[1];
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    public function setId(int $id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->name == null && $this->id > 0) {
            $this->name = ItemsService::$items[strtoupper($this->id)]['name'];
        }
        
        return $this->name ? $this->name : 'No Translation!';
    }
    
    /**
     * @return int
     */
    public function getSlot(): int
    {
        return $this->slot;
    }
    
    /**
     * @param int $slot
     * @return Item
     */
    public function setSlot(int $slot): Item
    {
        $this->slot = $slot;
        
        return $this;
    }
}
