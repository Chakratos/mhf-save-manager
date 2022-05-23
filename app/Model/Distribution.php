<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distribution")
 */
class Distribution
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
    protected $character_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $type;
    
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $deadline;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $event_name;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $description;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $times_acceptable;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_hr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_hr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_sr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_sr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_gr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_gr;
    
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $data;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    public static array $types = [
        0 => 'Bought',
        1 => 'Event',
        2 => 'Compensation',
        4 => 'Promo',
        6 => 'Subscription',
        7 => 'Event Item',
        8 => 'Promo Item',
        9 => 'Subscription Item',
    ];
    
    /**
     * @param int $id
     * @return Distribution
     */
    public function setId($id): Distribution
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCharacterId(): ?int
    {
        return $this->character_id;
    }
    
    /**
     * @param int $character_id
     * @return Distribution
     */
    public function setCharacterId($character_id): Distribution
    {
        $this->character_id = $character_id > 0 ? $character_id : null;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
    
    /**
     * @param int $type
     * @return Distribution
     */
    public function setType($type): Distribution
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }
    
    /**
     * @param \DateTime|null $deadline
     * @return Distribution
     */
    public function setDeadline($deadline): Distribution
    {
        if (!$deadline instanceof \DateTime && !empty($deadline)) {
            $deadline = new \DateTime($deadline);
        } else if (empty($deadline)) {
            $deadline = null;
        }
        $this->deadline = $deadline;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->event_name;
    }
    
    /**
     * @param string $event_name
     * @return Distribution
     */
    public function setEventName(string $event_name): Distribution
    {
        $this->event_name = $event_name;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     * @return Distribution
     */
    public function setDescription(string $description): Distribution
    {
        $this->description = $description;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getTimesAcceptable(): int
    {
        return $this->times_acceptable;
    }
    
    /**
     * @param int $times_acceptable
     * @return Distribution
     */
    public function setTimesAcceptable($times_acceptable): Distribution
    {
        $this->times_acceptable = $times_acceptable;
        
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
     * @return Distribution
     */
    public function setMinHr($min_hr): Distribution
    {
        $this->min_hr = $min_hr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxHr(): int
    {
        return $this->max_hr;
    }
    
    /**
     * @param int $max_hr
     * @return Distribution
     */
    public function setMaxHr($max_hr): Distribution
    {
        $this->max_hr = $max_hr;
        
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
     * @return Distribution
     */
    public function setMinSr($min_sr): Distribution
    {
        $this->min_sr = $min_sr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxSr(): int
    {
        return $this->max_sr;
    }
    
    /**
     * @param int $max_sr
     * @return Distribution
     */
    public function setMaxSr($max_sr): Distribution
    {
        $this->max_sr = $max_sr;
        
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
     * @return Distribution
     */
    public function setMinGr($min_gr): Distribution
    {
        $this->min_gr = $min_gr;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxGr(): int
    {
        return $this->max_gr;
    }
    
    /**
     * @param int $max_gr
     * @return Distribution
     */
    public function setMaxGr($max_gr): Distribution
    {
        $this->max_gr = $max_gr;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @param resource $data
     * @return Distribution
     */
    public function setData($data)
    {
        if (!is_resource($data)) {
            $handle = fopen('php://memory', 'br+');
            fwrite($handle, hex2bin($data));
            rewind($handle);
            
            $data = $handle;
        }
        $this->data = $data;
        
        return $this;
    }
}
