<?php


namespace MHFSaveManager\Model;


/*
 * 8 Byte per Item
 * 4 Byte Padding?
 * 2 Byte ID
 * 2 Byte Quantity
 */

use MHFSaveManager\Service\ItemsService;

//Item Box
/*
 * 8 Byte per Item
 * 4 Byte Padding?
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
    
    public function __toString()
    {
        return sprintf("%s | %sx %s", $this->id, $this->quantity, $this->name);
    }
    
    public function __construct($binary)
    {
        $this->binaryString = $binary;
        $this->read(4); //Padding?
        $this->id = $this->read(2, false);
        $this->name = ItemsService::$items[strtoupper($this->id)];
        $this->quantity = unpack('v', $this->read(2, true))[1];
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
