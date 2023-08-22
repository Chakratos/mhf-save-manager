<?php

namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;
use MHFSaveManager\Database\EM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gacha_entries")
 */
class GachaEntry
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(name="gacha_id", type="integer")
     * @var int
     */
    protected $gacha_id;
    
    /**
     * @ORM\Column(name="entry_type", type="integer")
     * @var int
     */
    protected $entry_type;
    
    /**
     * @ORM\Column(name="item_type", type="integer")
     * @var int
     */
    protected $item_type;
    
    /**
     * @ORM\Column(name="item_number", type="integer")
     * @var int
     */
    protected $item_number;
    
    /**
     * @ORM\Column(name="item_quantity", type="integer")
     * @var int
     */
    protected $item_quantity;
    
    /**
     * @ORM\Column(name="weight", type="integer")
     * @var int
     */
    protected $weight;
    
    /**
     * @ORM\Column(name="rarity", type="integer")
     * @var int
     */
    protected $rarity;
    
    /**
     * @ORM\Column(name="rolls", type="integer")
     * @var int
     */
    protected $rolls;
    
    /**
     * @ORM\Column(name="frontier_points", type="integer")
     * @var int
     */
    protected $frontier_points;
    
    /**
     * @ORM\Column(name="daily_limit", type="integer")
     * @var int
     */
    protected $daily_limit;
    
    /**
     * @return array
     */
    public function getGachaItems(): array
    {
        $queryBuilder = EM::getInstance()->createQueryBuilder();
        $queryBuilder->select('gi')
            ->from(GachaItem::class, 'gi')
            ->where('gi.entry_id = :gachaEntryId')
            ->setParameter('gachaEntryId', $this->getId());
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return GachaEntry
     */
    public function setId($id): GachaEntry
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGachaId(): int
    {
        return $this->gacha_id;
    }
    
    /**
     * @param int $gacha_id
     * @return GachaEntry
     */
    public function setGachaId($gacha_id): GachaEntry
    {
        $this->gacha_id = $gacha_id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getEntryType(): int
    {
        return $this->entry_type;
    }
    
    /**
     * @param int $entry_type
     * @return GachaEntry
     */
    public function setEntryType($entry_type): GachaEntry
    {
        $this->entry_type = $entry_type;
        
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
     * @return GachaEntry
     */
    public function setItemType($item_type): GachaEntry
    {
        $this->item_type = $item_type;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemNumber(): int
    {
        return $this->item_number;
    }
    
    /**
     * @param int $item_number
     * @return GachaEntry
     */
    public function setItemNumber($item_number): GachaEntry
    {
        $this->item_number = $item_number;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        return $this->item_quantity;
    }
    
    /**
     * @param int $item_quantity
     * @return GachaEntry
     */
    public function setItemQuantity($item_quantity): GachaEntry
    {
        $this->item_quantity = $item_quantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }
    
    /**
     * @param int $weight
     * @return GachaEntry
     */
    public function setWeight($weight): GachaEntry
    {
        $this->weight = $weight;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRarity(): int
    {
        return $this->rarity;
    }
    
    /**
     * @param int $rarity
     * @return GachaEntry
     */
    public function setRarity($rarity): GachaEntry
    {
        $this->rarity = $rarity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRolls(): int
    {
        return $this->rolls;
    }
    
    /**
     * @param int $rolls
     * @return GachaEntry
     */
    public function setRolls($rolls): GachaEntry
    {
        $this->rolls = $rolls;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getFrontierPoints(): int
    {
        return $this->frontier_points;
    }
    
    /**
     * @param int $frontier_points
     * @return GachaEntry
     */
    public function setFrontierPoints($frontier_points): GachaEntry
    {
        $this->frontier_points = $frontier_points;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getDailyLimit(): int
    {
        return $this->daily_limit;
    }
    
    /**
     * @param int $daily_limit
     * @return GachaEntry
     */
    public function setDailyLimit($daily_limit): GachaEntry
    {
        $this->daily_limit = $daily_limit;
        
        return $this;
    }
}
