<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shop_items")
 */
class ShopItem
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @var int
     */
    protected $id;
    
    // SHOP TYPES:
    // 01 = Running Gachas, 02 = actual gacha, 04 = N Points, 05 = GCP, 07 = Item to GCP, 08 = Diva Defense, 10 = Hunter's Road
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $shop_type;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $shop_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $item_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $cost;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quantity;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_hr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_sr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_gr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $store_level;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_quantity;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $road_floors;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $road_fatalis;
    
    public static array $categories = [
        'Basic Items',
        'Gatherables',
        'HR1-4',
        'HR5-7',
        'Decos',
        'Other Items',
        'GR1+',
        'Weekly Limited',
        'Super Special',
    ];
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return ShopItem
     */
    public function setId(int $id): ShopItem
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getShoptype(): int
    {
        return $this->shop_type;
    }
    
    /**
     * @param int $shoptype
     * @return ShopItem
     */
    public function setShoptype(int $shoptype): ShopItem
    {
        $this->shop_type = $shoptype;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getShopid(): int
    {
        return $this->shop_id;
    }
    
    /**
     * @return string
     */
    public function getShopidFancy(): string
    {
        return self::$categories[$this->shop_id];
    }
    
    /**
     * @param int $shopid
     * @return ShopItem
     */
    public function setShopid(int $shopid): ShopItem
    {
        $this->shop_id = $shopid;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemid(): int
    {
        return $this->item_id;
    }
    
    /**
     * @param int $itemid
     * @return ShopItem
     */
    public function setItemid(int $itemid): ShopItem
    {
        $this->item_id = $itemid;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }
    
    /**
     * @param int $cost
     * @return ShopItem
     */
    public function setCost(int $cost): ShopItem
    {
        $this->cost = $cost;
        
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
     * @return ShopItem
     */
    public function setQuantity(int $quantity): ShopItem
    {
        $this->quantity = $quantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinHr(): int
    {
        return $this->min_hr;
    }
    
    /**
     * @param int $min_hr
     * @return ShopItem
     */
    public function setMinHr(int $min_hr): ShopItem
    {
        $this->min_hr = $min_hr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinSr(): int
    {
        return $this->min_sr;
    }
    
    /**
     * @param int $min_sr
     * @return ShopItem
     */
    public function setMinSr(int $min_sr): ShopItem
    {
        $this->min_sr = $min_sr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinGr(): int
    {
        return $this->min_gr;
    }
    
    /**
     * @param int $min_gr
     * @return ShopItem
     */
    public function setMinGr(int $min_gr): ShopItem
    {
        $this->min_gr = $min_gr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getStoreLevel(): int
    {
        return $this->store_level;
    }
    
    /**
     * @param int $store_level
     * @return ShopItem
     */
    public function setStoreLevel(int $store_level): ShopItem
    {
        $this->store_level = $store_level;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxQuantity(): int
    {
        return $this->max_quantity;
    }
    
    /**
     * @param int $max_quantity
     * @return ShopItem
     */
    public function setMaxQuantity(int $max_quantity): ShopItem
    {
        $this->max_quantity = $max_quantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRoadFloors(): int
    {
        return $this->road_floors;
    }
    
    /**
     * @param int $road_floors
     * @return ShopItem
     */
    public function setRoadFloors(int $road_floors): ShopItem
    {
        $this->road_floors = $road_floors;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRoadFatalis(): int
    {
        return $this->road_fatalis;
    }
    
    /**
     * @param int $road_fatalis
     * @return ShopItem
     */
    public function setRoadFatalis(int $road_fatalis): ShopItem
    {
        $this->road_fatalis = $road_fatalis;
        
        return $this;
    }
}
