<?php


namespace MHFSaveManager\Model;


/*
 * 16 Byte per Equip
 * 5 Bytes unkown
 * 1 Byte Type (2 = Helmet, 3 = Torso, 4 = Hands, 5 = Legs, 6 = Melee, 7 = Range)
 * 2 Byte ID
 * 2 Byte Upgrade Level (0 = 1 ... 6 = 7)
 * 2 Byte Deco 1
 * 2 Byte Deco 2
 * 2 Byte Deco 3
 */

use MHFSaveManager\Service\EquipService;

class Equip extends AbstractBinaryModel
{
    /**
     * @var string
     */
    protected $id = "0000";
    /**
     * @var string
     */
    protected $type = "00";
    /**
     * @var int
     */
    protected $upgradeLevel = 0;
    /**
     * @var array
     */
    protected $decorations = [];
    /**
     * @var string
     */
    protected $name = "";
    /**
     * @var string
     */
    protected $weaponType = "";
    
    public function __toString()
    {
        if ($this->isWeapon()) {
            $result = sprintf("%s | [%s][%s] %s (lvl:%s)", $this->id, $this->getTypeAsString(), $this->getWeaponType(), $this->name, $this->getUpgradeLevel());
        } else {
            $result = sprintf("%s | [%s] %s (lvl:%s)", $this->id, $this->getTypeAsString(), $this->name, $this->getUpgradeLevel());
        }
        
        foreach ($this->decorations as $decoration) {
            $result .= sprintf(" | Deco: %s",$decoration);
        }
        
        return $result;
    }
    
    public function __construct(string $binary)
    {
        $this->binaryString = $binary;
        $this->read(5); //Padding?
        $this->type = $this->read(1);
        $this->id = $this->read(2);
        $this->upgradeLevel = unpack('v', $this->read(2, true))[1];
        
        for ($i = 0; $i <= 2; $i++) {
            $decorationId = $this->read(2);
            if ($decorationId == "0000") {
                break;
            }
            $this->decorations[] = new Decoration($decorationId);
        }
        
        if ($this->getTypeAsString() == "Ranged" || $this->getTypeAsString() == "Melee") {
            $arrayName = lcfirst($this->getTypeAsString()) . 'Name';
            $arrayType = lcfirst($this->getTypeAsString()) . 'Type';
            $this->weaponType = (EquipService::$$arrayType)[strtoupper($this->id)];
            $this->name = (EquipService::$$arrayName)[strtoupper($this->id)];
        } else {
            $arrayName = lcfirst($this->getTypeAsString()) . 'Name';
            $this->name = (EquipService::$$arrayName)[strtoupper($this->id)];
        }
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @return int
     */
    public function getUpgradeLevel(): int
    {
        return $this->upgradeLevel;
    }
    
    /**
     * @return array
     */
    public function getDecorations(): array
    {
        return $this->decorations;
    }
    
    /**
     * @return bool
     */
    public function hasDecorations(): bool
    {
        return (bool)count($this->decorations);
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getTypeAsString(): string
    {
        return EquipService::$types[$this->getType()];
    }
    
    /**
     * @return bool
     */
    public function isWeapon(): bool
    {
        return $this->weaponType != "";
    }
    
    /**
     * @return string
     */
    public function getWeaponType(): string
    {
        return $this->weaponType;
    }
}
