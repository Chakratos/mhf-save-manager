<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="characters")
 */
class Character
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(type="bigint")
     * @var int
     */
    protected $user_id;
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $is_female;
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $is_new_character;
    /**
     * @ORM\Column(type="string", length=15)
     * @var string
     */
    protected $name;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $last_login;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $gcp;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $netcafe_points;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $frontier_points;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $kouryou_point;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $gacha_trial;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $gacha_prem;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $savedata;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $decomyset;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $hunternavi;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $otomoairou;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $partner;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $platebox;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $platedata;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $platemyset;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $rengokudata;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $savemercenary;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $minidata;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $scenariodata;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $savefavoritequest;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $skin_hist;
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $restrict_guild_scout;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return Character
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * @param int $user_id
     * @return Character
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isFemale()
    {
        return $this->is_female;
    }
    
    /**
     * @param boolean $is_female
     * @return Character
     */
    public function setIsFemale($is_female)
    {
        $this->is_female = $is_female;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isNewCharacter()
    {
        return $this->is_new_character;
    }
    
    /**
     * @param boolean $is_new_character
     * @return Character
     */
    public function setIsNewCharacter($is_new_character)
    {
        $this->is_new_character = $is_new_character;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isGrOverrideMode()
    {
        return $this->gr_override_mode;
    }
    
    /**
     * @param boolean $gr_override_mode
     * @return Character
     */
    public function setGrOverrideMode($gr_override_mode)
    {
        $this->gr_override_mode = $gr_override_mode;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return Character
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUnkDescString()
    {
        return $this->unk_desc_string;
    }
    
    /**
     * @param string $unk_desc_string
     * @return Character
     */
    public function setUnkDescString($unk_desc_string)
    {
        $this->unk_desc_string = $unk_desc_string;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGrOverrideLevel()
    {
        return $this->gr_override_level;
    }
    
    /**
     * @param int $gr_override_level
     * @return Character
     */
    public function setGrOverrideLevel($gr_override_level)
    {
        $this->gr_override_level = $gr_override_level;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGrOverrideUnk0()
    {
        return $this->gr_override_unk0;
    }
    
    /**
     * @param int $gr_override_unk0
     * @return Character
     */
    public function setGrOverrideUnk0($gr_override_unk0)
    {
        $this->gr_override_unk0 = $gr_override_unk0;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGrOverrideUnk1()
    {
        return $this->gr_override_unk1;
    }
    
    /**
     * @param int $gr_override_unk1
     * @return Character
     */
    public function setGrOverrideUnk1($gr_override_unk1)
    {
        $this->gr_override_unk1 = $gr_override_unk1;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getExp()
    {
        return $this->exp;
    }
    
    /**
     * @param int $exp
     * @return Character
     */
    public function setExp($exp)
    {
        $this->exp = $exp;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getWeapon()
    {
        return $this->weapon;
    }
    
    /**
     * @param int $weapon
     * @return Character
     */
    public function setWeapon($weapon)
    {
        $this->weapon = $weapon;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLastLogin($fancyFormat = true)
    {
        return $fancyFormat ? date('F j, Y, G:i', $this->last_login) : $this->last_login;
    }
    
    /**
     * @param int $last_login
     * @return Character
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getSavedata()
    {
        return $this->savedata;
    }
    
    /**
     * @param resource $savedata
     * @return Character
     */
    public function setSavedata($savedata)
    {
        $this->savedata = $savedata;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getDecomyset()
    {
        return $this->decomyset;
    }
    
    /**
     * @param resource $decomyset
     * @return Character
     */
    public function setDecomyset($decomyset)
    {
        $this->decomyset = $decomyset;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getHunternavi()
    {
        return $this->hunternavi;
    }
    
    /**
     * @param resource $hunternavi
     * @return Character
     */
    public function setHunternavi($hunternavi)
    {
        $this->hunternavi = $hunternavi;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getOtomoairou()
    {
        return $this->otomoairou;
    }
    
    /**
     * @param resource $otomoairou
     * @return Character
     */
    public function setOtomoairou($otomoairou)
    {
        $this->otomoairou = $otomoairou;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getPartner()
    {
        return $this->partner;
    }
    
    /**
     * @param resource $partner
     * @return Character
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getPlatebox()
    {
        return $this->platebox;
    }
    
    /**
     * @param resource $platebox
     * @return Character
     */
    public function setPlatebox($platebox)
    {
        $this->platebox = $platebox;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getPlatedata()
    {
        return $this->platedata;
    }
    
    /**
     * @param resource $platedata
     * @return Character
     */
    public function setPlatedata($platedata)
    {
        $this->platedata = $platedata;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getPlatemyset()
    {
        return $this->platemyset;
    }
    
    /**
     * @param resource $platemyset
     * @return Character
     */
    public function setPlatemyset($platemyset)
    {
        $this->platemyset = $platemyset;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getRengokudata()
    {
        return $this->rengokudata;
    }
    
    /**
     * @param resource $rengokudata
     * @return Character
     */
    public function setRengokudata($rengokudata)
    {
        $this->rengokudata = $rengokudata;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getSavemercenary()
    {
        return $this->savemercenary;
    }
    
    /**
     * @param resource $savemercenary
     * @return Character
     */
    public function setSavemercenary($savemercenary)
    {
        $this->savemercenary = $savemercenary;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getSkinhist()
    {
        return $this->skin_hist;
    }
    
    /**
     * @param resource $skinhist
     * @return Character
     */
    public function setSkinhist($skinhist)
    {
        $this->skin_hist = $skinhist;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isRestrictGuildScout()
    {
        return $this->restrict_guild_scout;
    }
    
    /**
     * @param boolean $restrict_guild_scout
     * @return Character
     */
    public function setRestrictGuildScout($restrict_guild_scout)
    {
        $this->restrict_guild_scout = $restrict_guild_scout;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGcp()
    {
        return $this->gcp;
    }
    
    /**
     * @param int $gcp
     * @return Character
     */
    public function setGcp(int $gcp): Character
    {
        $this->gcp = $gcp;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getNetcafepoints()
    {
        return $this->netcafe_points;
    }
    
    /**
     * @param int $netcafe_points
     * @return Character
     */
    public function setNetcafepoints(int $netcafe_points): Character
    {
        $this->netcafe_points = $netcafe_points;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getFrontierpoints()
    {
        return $this->frontier_points;
    }
    
    /**
     * @param int $frontier_points
     * @return Character
     */
    public function setFrontierpoints(int $frontier_points): Character
    {
        $this->frontier_points = $frontier_points;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getKouryoupoint()
    {
        return $this->kouryou_point;
    }
    
    /**
     * @param int $kouryou_point
     * @return Character
     */
    public function setKouryoupoint(int $kouryou_point): Character
    {
        $this->kouryou_point = $kouryou_point;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGachatrial()
    {
        return $this->gacha_trial;
    }
    
    /**
     * @param int $gacha_trial
     * @return Character
     */
    public function setGachatrial(int $gacha_trial): Character
    {
        $this->gacha_trial = $gacha_trial;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGachaprem()
    {
        return $this->gacha_prem;
    }
    
    /**
     * @param int $gacha_prem
     * @return Character
     */
    public function setGachaprem(int $gacha_prem): Character
    {
        $this->gacha_prem = $gacha_prem;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getMinidata()
    {
        return $this->minidata;
    }
    
    /**
     * @param resource $minidata
     */
    public function setMinidata($minidata): void
    {
        $this->minidata = $minidata;
    }
    
    /**
     * @return resource
     */
    public function getScenariodata()
    {
        return $this->scenariodata;
    }
    
    /**
     * @param resource $scenariodata
     */
    public function setScenariodata($scenariodata): void
    {
        $this->scenariodata = $scenariodata;
    }
    
    /**
     * @return resource
     */
    public function getSavefavoritequest()
    {
        return $this->savefavoritequest;
    }
    
    /**
     * @param resource $savefavouritequest
     */
    public function setSavefavoritequest($savefavoritequest): void
    {
        $this->savefavoritequest = $savefavoritequest;
    }
}
