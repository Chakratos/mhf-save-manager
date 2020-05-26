<?php


namespace MHFSaveManager\Model;


class ItemPreset extends ItemPouch
{
    protected $name = "";
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
