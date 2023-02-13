<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="normal_shop_items")
 */
class NormalShopItem
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
    protected $shoptype;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $shopid;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $itemid;
    
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
    protected $req_store_level;
    
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
     * @return NormalShopItem
     */
    public function setId(int $id): NormalShopItem
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getShoptype(): int
    {
        return $this->shoptype;
    }
    
    /**
     * @param int $shoptype
     * @return NormalShopItem
     */
    public function setShoptype(int $shoptype): NormalShopItem
    {
        $this->shoptype = $shoptype;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getShopid(): int
    {
        return $this->shopid;
    }
    
    /**
     * @return string
     */
    public function getShopidFancy(): string
    {
        return self::$categories[$this->shopid];
    }
    
    /**
     * @param int $shopid
     * @return NormalShopItem
     */
    public function setShopid(int $shopid): NormalShopItem
    {
        $this->shopid = $shopid;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getItemid(): int
    {
        return $this->itemid;
    }
    
    /**
     * @param int $itemid
     * @return NormalShopItem
     */
    public function setItemid(int $itemid): NormalShopItem
    {
        $this->itemid = $itemid;
        
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
     * @return NormalShopItem
     */
    public function setCost(int $cost): NormalShopItem
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
     * @return NormalShopItem
     */
    public function setQuantity(int $quantity): NormalShopItem
    {
        $this->quantity = $quantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMin_hr(): int
    {
        return $this->min_hr;
    }
    
    /**
     * @param int $min_hr
     * @return NormalShopItem
     */
    public function setMin_hr(int $min_hr): NormalShopItem
    {
        $this->min_hr = $min_hr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMin_sr(): int
    {
        return $this->min_sr;
    }
    
    /**
     * @param int $min_sr
     * @return NormalShopItem
     */
    public function setMin_sr(int $min_sr): NormalShopItem
    {
        $this->min_sr = $min_sr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMin_gr(): int
    {
        return $this->min_gr;
    }
    
    /**
     * @param int $min_gr
     * @return NormalShopItem
     */
    public function setMin_gr(int $min_gr): NormalShopItem
    {
        $this->min_gr = $min_gr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getReq_store_level(): int
    {
        return $this->req_store_level;
    }
    
    /**
     * @param int $req_store_level
     * @return NormalShopItem
     */
    public function setReq_store_level(int $req_store_level): NormalShopItem
    {
        $this->req_store_level = $req_store_level;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMax_quantity(): int
    {
        return $this->max_quantity;
    }
    
    /**
     * @param int $max_quantity
     * @return NormalShopItem
     */
    public function setMax_quantity(int $max_quantity): NormalShopItem
    {
        $this->max_quantity = $max_quantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRoad_floors(): int
    {
        return $this->road_floors;
    }
    
    /**
     * @param int $road_floors
     * @return NormalShopItem
     */
    public function setRoad_floors(int $road_floors): NormalShopItem
    {
        $this->road_floors = $road_floors;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRoad_fatalis(): int
    {
        return $this->road_fatalis;
    }
    
    /**
     * @param int $road_fatalis
     * @return NormalShopItem
     */
    public function setRoad_fatalis(int $road_fatalis): NormalShopItem
    {
        $this->road_fatalis = $road_fatalis;
        
        return $this;
    }
}
