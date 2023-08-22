<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_quests")
 */
class EventQuest
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
    protected $max_players;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quest_type;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quest_id;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $mark;
    
    public static array $quest_types = [
        8 => 'Festa Winners',
        9 => 'Campaign',
        13 => 'VS',
        16 => ' Ravi (Normal)',
        18 => 'HR Event',
        22 => 'Ravi (Violent)',
        24 => 'Series',
        26 => 'Daily',
        28 => 'G Event',
        30 => 'G Daily',
        31 => 'G Urgent',
        38 => 'HR Exotic',
        39 => 'G Exotic',
        40 => 'Ravi (Berserk)',
        43 => 'Superior/Zenith?',
        46 => 'Interception',
        47 => 'Interception Branch',
        48 => 'Interception Urgent',
        50 => 'Ravi (Extreme)',
        51 => 'Ravi (Small Berserk)',
        52 => 'Superior',
        53 => 'G Superier',
        54 => 'G Armo',
    ];
    
    public static array $quest_marks = [
        0 => 'None',
        1 => 'Recommended',
        2 => 'New',
        3 => 'Recommended',
        4 => 'Refine',
        9 => 'Recommended',
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
     * @return EventQuest
     */
    public function setId(int $id): EventQuest
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxPlayers(): int
    {
        return $this->max_players;
    }
    
    /**
     * @param int $max_players
     * @return EventQuest
     */
    public function setMaxPlayers(int $max_players): EventQuest
    {
        $this->max_players = $max_players;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuestType(): int
    {
        return $this->quest_type;
    }
    
    /**
     * @param int $quest_type
     * @return EventQuest
     */
    public function setQuestType(int $quest_type): EventQuest
    {
        $this->quest_type = $quest_type;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuestId(): int
    {
        return $this->quest_id;
    }
    
    /**
     * @param int $quest_id
     * @return EventQuest
     */
    public function setQuestId(int $quest_id): EventQuest
    {
        $this->quest_id = $quest_id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMark(): int
    {
        return $this->mark;
    }
    
    /**
     * @param int $mark
     * @return EventQuest
     */
    public function setMark(int $mark): EventQuest
    {
        $this->mark = $mark;
        
        return $this;
    }
}
