<?php

namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gacha_items")
 */
class GachaItem
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(name="entry_id", type="integer")
     * @var int
     */
    protected $entry_id;
    
    /**
     * @ORM\Column(name="item_type", type="integer")
     * @var int
     */
    protected $item_type;
    
    /**
     * @ORM\Column(name="item_id", type="integer")
     * @var int
     */
    protected $item_id;
    
    /**
     * @ORM\Column(name="quantity", type="integer")
     * @var int
     */
    protected $quantity;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return GachaItem
     */
    public function setId($id): GachaItem
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getEntryId(): int
    {
        return $this->entry_id;
    }
    
    /**
     * @param int $entry_id
     * @return GachaItem
     */
    public function setEntryId($entry_id): GachaItem
    {
        $this->entry_id = $entry_id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemType(): int
    {
        return $this->item_type;
    }
    
    /**
     * @param int $item_type
     * @return GachaItem
     */
    public function setItemType($item_type): GachaItem
    {
        $this->item_type = $item_type;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->item_id;
    }
    
    /**
     * @param int $item_id
     * @return GachaItem
     */
    public function setItemId($item_id): GachaItem
    {
        $this->item_id = $item_id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    /**
     * @param int $quantity
     * @return GachaItem
     */
    public function setQuantity($quantity): GachaItem
    {
        $this->quantity = $quantity;
        
        return $this;
    }
}
