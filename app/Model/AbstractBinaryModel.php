<?php


namespace MHFSaveManager\Model;


class AbstractBinaryModel
{
    /**
     * @var string
     */
    protected $binaryString = "";
    /**
     * @var int
     */
    protected $binaryPos = 0;
    
    protected function read(int $bytes, bool $raw = false, $debug = false): string
    {
        $result = substr($this->binaryString, $this->binaryPos, $bytes);
        $test = bin2hex($result);
        $this->binaryPos += $bytes;
        
        if ($raw) {
            return $result;
        }
        
        return bin2hex($result);
    }
}
