<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gacha_shop")
 */
class GachaShop
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $url_feature;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $hidden;
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $url_banner;
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $url_thumbnail;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $recommended;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $wide;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_gr;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_hr;
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $name;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $gacha_type;
    
    public static array $types = [
        'Normal',
        'Step-Up',
        '2',
        '3',
        'Box',
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
     * @return GachaShop
     */
    public function setId(int $id): GachaShop
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUrlFeature(): string
    {
        return $this->url_feature;
    }
    
    /**
     * @param string $url_feature
     * @return GachaShop
     */
    public function setUrlFeature(string $url_feature): GachaShop
    {
        $this->url_feature = $url_feature;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }
    
    /**
     * @param bool $hidden
     * @return GachaShop
     */
    public function setHidden(bool $hidden): GachaShop
    {
        $this->hidden = $hidden;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUrlBanner(): string
    {
        return $this->url_banner;
    }
    
    /**
     * @param string $url_banner
     * @return GachaShop
     */
    public function setUrlBanner(string $url_banner): GachaShop
    {
        $this->url_banner = $url_banner;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUrlThumbnail(): string
    {
        return $this->url_thumbnail;
    }
    
    /**
     * @param string $url_thumbnail
     * @return GachaShop
     */
    public function setUrlThumbnail(string $url_thumbnail): GachaShop
    {
        $this->url_thumbnail = $url_thumbnail;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isRecommended(): bool
    {
        return $this->recommended;
    }
    
    /**
     * @param bool $recommended
     * @return GachaShop
     */
    public function setRecommended(bool $recommended): GachaShop
    {
        $this->recommended = $recommended;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isWide(): bool
    {
        return $this->wide;
    }
    
    /**
     * @param bool $wide
     * @return GachaShop
     */
    public function setWide(bool $wide): GachaShop
    {
        $this->wide = $wide;
        
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
     * @return GachaShop
     */
    public function setMinGr(int $min_gr): GachaShop
    {
        $this->min_gr = $min_gr;
        
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
     * @return GachaShop
     */
    public function setMinHr(int $min_hr): GachaShop
    {
        $this->min_hr = $min_hr;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return GachaShop
     */
    public function setName(string $name): GachaShop
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getGachaType(): int
    {
        return $this->gacha_type;
    }
    
    /**
     * @param int $gacha_type
     * @return GachaShop
     */
    public function setGachaType(int $gacha_type): GachaShop
    {
        $this->gacha_type = $gacha_type;
        
        return $this;
    }
}
