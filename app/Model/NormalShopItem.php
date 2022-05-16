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
     * @ORM\Column(name="itemhash", type="integer")
     * @ORM\Id
     * @var int
     */
    protected $itemhash;
    
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
    protected $points;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $tradequantity;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $rankreqlow;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $rankreqhigh;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $rankreqg;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $storelevelreq;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $maximumquantity;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $boughtquantity;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $roadfloorsrequired;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $weeklyfataliskills;
    
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
    public function getItemhash(): int
    {
        return $this->itemhash;
    }
    
    /**
     * @param int $itemhash
     * @return NormalShopItem
     */
    public function setItemhash(int $itemhash): NormalShopItem
    {
        $this->itemhash = $itemhash;
        
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
    public function getPoints(): int
    {
        return $this->points;
    }
    
    /**
     * @param int $points
     * @return NormalShopItem
     */
    public function setPoints(int $points): NormalShopItem
    {
        $this->points = $points;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getTradequantity(): int
    {
        return $this->tradequantity;
    }
    
    /**
     * @param int $tradequantity
     * @return NormalShopItem
     */
    public function setTradequantity(int $tradequantity): NormalShopItem
    {
        $this->tradequantity = $tradequantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRankreqlow(): int
    {
        return $this->rankreqlow;
    }
    
    /**
     * @param int $rankreqlow
     * @return NormalShopItem
     */
    public function setRankreqlow(int $rankreqlow): NormalShopItem
    {
        $this->rankreqlow = $rankreqlow;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRankreqhigh(): int
    {
        return $this->rankreqhigh;
    }
    
    /**
     * @param int $rankreqhigh
     * @return NormalShopItem
     */
    public function setRankreqhigh(int $rankreqhigh): NormalShopItem
    {
        $this->rankreqhigh = $rankreqhigh;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRankreqg(): int
    {
        return $this->rankreqg;
    }
    
    /**
     * @param int $rankreqg
     * @return NormalShopItem
     */
    public function setRankreqg(int $rankreqg): NormalShopItem
    {
        $this->rankreqg = $rankreqg;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getStorelevelreq(): int
    {
        return $this->storelevelreq;
    }
    
    /**
     * @param int $storelevelreq
     * @return NormalShopItem
     */
    public function setStorelevelreq(int $storelevelreq): NormalShopItem
    {
        $this->storelevelreq = $storelevelreq;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaximumquantity(): int
    {
        return $this->maximumquantity;
    }
    
    /**
     * @param int $maximumquantity
     * @return NormalShopItem
     */
    public function setMaximumquantity(int $maximumquantity): NormalShopItem
    {
        $this->maximumquantity = $maximumquantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getBoughtquantity(): int
    {
        return $this->boughtquantity;
    }
    
    /**
     * @param int $boughtquantity
     * @return NormalShopItem
     */
    public function setBoughtquantity(int $boughtquantity): NormalShopItem
    {
        $this->boughtquantity = $boughtquantity;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRoadfloorsrequired(): int
    {
        return $this->roadfloorsrequired;
    }
    
    /**
     * @param int $roadfloorsrequired
     * @return NormalShopItem
     */
    public function setRoadfloorsrequired(int $roadfloorsrequired): NormalShopItem
    {
        $this->roadfloorsrequired = $roadfloorsrequired;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getWeeklyfataliskills(): int
    {
        return $this->weeklyfataliskills;
    }
    
    /**
     * @param int $weeklyfataliskills
     * @return NormalShopItem
     */
    public function setWeeklyfataliskills(int $weeklyfataliskills): NormalShopItem
    {
        $this->weeklyfataliskills = $weeklyfataliskills;
        
        return $this;
    }
}
