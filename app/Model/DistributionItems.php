<?php


namespace MHFSaveManager\Model;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distribution_items")
 */
class DistributionItems implements JsonSerializable, JsonDeserializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
     protected $id;

     /**
      * @ORM\Column(type="integer")
      * @var int
      */
     protected $distribution_id;

     /**
      * @ORM\Column(type="integer")
      * @var int
      */
     protected $item_type;
        
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $item_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quantity;

    public static array $types = [
        0 => 'Legs',
        1 => 'Head',
        2 => 'Chest',
        3 => 'Arms',
        4 => 'Waist',
        5 => 'Melee',
        6 => 'Ranged',
        7 => 'Item',
        8 => 'Furniture',
        9 => '9',
        10 => 'Zenny',
        11 => '11',
        12 => 'Festi Points',
        13 => '13',
        14 => 'TorePoint',
        15 => 'Poogie Outfits',
        16 => 'Restyle Points',
        17 => 'N Points',
        18 => 'GoocooOutfit',
        19 => 'Gacha Coins',
        20 => 'Trial Gacha Coins',
        21 => 'Frontier Points',
        22 => '22',
        23 => 'Ryoudan Points (RP)',
        24 => '24',
        25 => 'Bond Points',
        26 => '26',
        27 => '27',
        28 => 'Special Hall',
        29 => 'Song Note',
        30 => 'Item Box Pages',
        31 => 'Equipment Box Pages',
    ];
    
    public function __toString()
    {
        return sprintf("id:%d, distribution_id:%d, item_type:%d, item_id:%d, quantity:%d", 
            $this->id, $this->distribution_id, $this->item_type, $this->item_id, $this->quantity);
    }
        
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
        
    /**
     * @return int
     */
    public function getDistributionId(): int
    { 
        return $this->distribution_id;
    }
        
    /**
     * @param int $id
     * @return DistributionItems
     */
    public function setDistributionId(int $id): DistributionItems
    { 
        $this->distribution_id = $id;
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
     * @param int $type
     * @return DistributionItems
     */
    public function setItemType(int $type): DistributionItems
    {
        $this->item_type = $type;
        
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getItemId(): int|null
    {
        return $this->item_id;
    }
    
    /**
     * @return DistributionItems
     */
    public function setItemId(int $item_id): DistributionItems
    {
        $this->item_id = $item_id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getItemIdString(bool $littleEndian = true): string
    {
        if(!$this->item_id) {
            return "0000";
        }
        $res = strtoupper(str_pad(dechex($this->item_id), 4, "0", STR_PAD_LEFT));
        if($littleEndian){
            $res = substr($res,2, 2) . substr($res,0, 2);
        }
        return $res;
    }

    /**
     * @param string $item_id
     * @param bool $littleEndian
     * @return DistributionItems
     */
    public function setItemIdString(string $item_id, bool $littleEndian = true): DistributionItems
    {
        if (strlen($item_id) < 4) {
            $item_id = "0000";
        }
        if ($littleEndian) {
            $item_id = substr($item_id,2, 2) . substr($item_id,0, 2);
        }
        $this->item_id = hexdec($item_id);
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuantity(): int|null
    {
        return $this->quantity;
    }
    
    /**
     * @param int $quantity
     * @return DistributionItems
     */
    public function setQuantity(int $quantity): DistributionItems
    {
        $this->quantity = $quantity;
        
        return $this;
    }

    /**
     * Serialize into a json object
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'distribution_id' => $this->distribution_id,
            'item_type' => $this->item_type,
            'item_id' => $this->item_id,
            'quantity' => $this->quantity,
        ];
    }
    
    /**
     * @param array $jsonObject
     * @return DistributionItems
     */
    public function setFromJson(array $jsonObject) : DistributionItems
    {
        $this->id = $jsonObject['id'];
        $this->distribution_id = $jsonObject['distribution_id'];
        $this->item_type = $jsonObject['item_type'];
        $this->item_id = $jsonObject['item_id'];
        $this->quantity = $jsonObject['quantity'];
        return $this;
    }
}
