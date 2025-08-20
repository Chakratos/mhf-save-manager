<?php

namespace MHFSaveManager\Model;

use JsonSerializable;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distribution")
 */
class Distribution implements JsonSerializable, JsonDeserializable
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
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $min_hr;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $max_hr;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $min_sr;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $max_sr;
    
    /**
     * @ORM\Column(type="integer", nullable=true))
     * @var int
     */
    protected $min_gr;
    
    /**
     * @ORM\Column(type="integer", nullable=true))
     * @var int
     */
    protected $max_gr;

    /**
     * @ORM\Column(type="integer", nullable=true))
     * @var int
     */
    protected $rights;

    /**
     * @ORM\Column(type="boolean", nullable=true))
     * @var bool
     */
    protected $selection;
        
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
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
        if (!preg_match('/^~C(\d\d)/', $this->event_name)) {
            return $this->event_name;
        }
    
        return substr($this->event_name, 4);
    }
    
    public function getEventNameColor(): string
    {
        $matches = [];
        preg_match('/^~C(\d\d)/', $this->event_name, $matches);
        
        return count($matches) > 1 ? $matches[1] : "";
    }
    
    /**
     * @param string $event_name
     * @return Distribution
     */
    public function setEventName(string $event_name): Distribution
    {
        if (!preg_match('/^~C(\d\d)/', $event_name)) {
            $event_name = '~C01' . $event_name;
        }
        $this->event_name = $event_name;
    
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        if (!preg_match('/^~C(\d\d)/', $this->description)) {
            return $this->description;
        }
    
        return substr($this->description, 4);
    }
    
    public function getDescriptionColor(): string
    {
        $matches = [];
        preg_match('/^~C(\d\d)/', $this->description, $matches);
    
        return count($matches) > 1 ? $matches[1] : "";
    }
    
    /**
     * @param string $description
     * @return Distribution
     */
    public function setDescription(string $description): Distribution
    {
        if (!preg_match('/^~C(\d\d)/', $description)) {
            $description = '~C01' . $description;
        }
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
    public function getMinHr(): int|null
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
    public function getMaxHr(): int|null
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
    public function getMinSr(): int|null
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
    public function getMaxSr(): int|null
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
    public function getMinGr(): int|null
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
    public function getMaxGr(): int|null
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
     * @return int
     */
    public function getRights(): int
    {
        return $this->rights | 0;
    }
    
    /**
     * @param int $rights
     * @return Distribution
     */
    public function setRights($rights): Distribution
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSelection(): bool
    {
        return $this->selection | false;
    }
    
    /**
     * @param int $selection
     * @return Distribution
     */
    public function setSelection($selection): Distribution
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Serialize into a json object
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'character_id' => $this->character_id,
            'type' => $this->type,
            'deadline' => $this->deadline ? $this->deadline->getTimestamp() : null,
            'event_name' => $this->event_name,
            'description' => $this->description,
            'times_acceptable' => $this->times_acceptable,
            'min_hr' => $this->min_hr,
            'max_hr' => $this->max_hr,
            'min_sr' => $this->min_sr,
            'max_sr' => $this->max_sr,
            'min_gr' => $this->min_gr,
            'max_gr' => $this->max_gr,
            'rights' => $this->rights,
            'selection' => $this->selection,
        ];
    }

    /**
     * @param array $jsonObject
     * @return Distribution
     */
    public function setFromJson(array $jsonObject) : Distribution
    {
        $this->id = $jsonObject['id'];
        $this->character_id = $jsonObject['character_id'];
        $this->type = $jsonObject['type'];
        $this->event_name = $jsonObject['event_name'];
        $this->description = $jsonObject['description'];
        $this->times_acceptable = $jsonObject['times_acceptable'];
        $this->min_hr = $jsonObject['min_hr'];
        $this->max_hr = $jsonObject['max_hr'];
        $this->min_sr = $jsonObject['min_sr'];
        $this->max_sr = $jsonObject['max_sr'];
        $this->min_gr = $jsonObject['min_gr'];
        $this->max_gr = $jsonObject['max_gr'];
        $this->rights = $jsonObject['rights'];
        $this->selection = $jsonObject['selection'];

        if($jsonObject['deadline']){
            $dateData = new DateTime();
            $dateData->setTimestamp($jsonObject['deadline']);
            $this->deadline = $dateData;
        }
        
        return $this;
    }
}
