<?php


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $username;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $password;
    /**
     * @ORM\Column(type="blob")
     * @var resource
     */
    protected $item_box;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $rights;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $last_character;
    /** @ORM\Column(type="datetime") **/
    protected $last_login;
    /** @ORM\Column(type="datetime") **/
    protected $return_expires;
    /**
     * @ORM\Column(type="integer")
     * @var ?int
     */
    protected ?int $gacha_premium;
    /**
     * @ORM\Column(type="integer")
     * @var ?int
     */
    protected ?int $gacha_trial;
    /**
     * @ORM\Column(type="integer")
     * @var ?int
     */
    protected ?int $frontier_points;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }
    
    /**
     * @param int $user_id
     * @return User
     */
    public function setUserId(int $user_id): User
    {
        $this->user_id = $user_id;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isIsFemale(): bool
    {
        return $this->is_female;
    }
    
    /**
     * @param bool $is_female
     * @return User
     */
    public function setIsFemale(bool $is_female): User
    {
        $this->is_female = $is_female;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isIsNewCharacter(): bool
    {
        return $this->is_new_character;
    }
    
    /**
     * @param bool $is_new_character
     * @return User
     */
    public function setIsNewCharacter(bool $is_new_character): User
    {
        $this->is_new_character = $is_new_character;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    
    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getItemBox()
    {
        return $this->item_box;
    }
    
    /**
     * @param resource $item_box
     * @return User
     */
    public function setItemBox($item_box)
    {
        $this->item_box = $item_box;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRights(): int
    {
        return $this->rights;
    }
    
    /**
     * @param int $rights
     * @return User
     */
    public function setRights(int $rights): User
    {
        $this->rights = $rights;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getLastCharacter(): int
    {
        return $this->last_character;
    }
    
    /**
     * @param int $last_character
     * @return User
     */
    public function setLastCharacter(int $last_character): User
    {
        $this->last_character = $last_character;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }
    
    /**
     * @param mixed $last_login
     * @return User
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getReturnExpires()
    {
        return $this->return_expires;
    }
    
    /**
     * @param mixed $return_expires
     * @return User
     */
    public function setReturnExpires($return_expires)
    {
        $this->return_expires = $return_expires;
        
        return $this;
    }
    
    /**
     * @return ?int
     */
    public function getGachapremium(): ?int
    {
        return $this->gacha_premium;
    }
    
    /**
     * @param ?int $gacha_premium
     * @return User
     */
    public function setGachapremium(?int $gacha_premium): User
    {
        $this->gacha_premium = $gacha_premium;
        
        return $this;
    }
    
    /**
     * @return ?int
     */
    public function getGachatrial(): ?int
    {
        return $this->gacha_trial;
    }
    
    /**
     * @param ?int $gacha_trial
     * @return User
     */
    public function setGachatrial(?int $gacha_trial): User
    {
        $this->gacha_trial = $gacha_trial;
        
        return $this;
    }
    
    /**
     * @return ?int
     */
    public function getFrontierpoints(): ?int
    {
        return $this->frontier_points;
    }
    
    /**
     * @param ?int $frontier_points
     * @return User
     */
    public function setFrontierpoints(?int $frontier_points): User
    {
        $this->frontier_points = $frontier_points;
        
        return $this;
    }
}
