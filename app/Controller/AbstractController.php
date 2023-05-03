<?php


namespace MHFSaveManager\Controller;


use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Distribution;
use MHFSaveManager\Service\ResponseService;

/**
 *
 */
abstract class AbstractController
{
    protected static string $itemName;
    protected static string $itemClass;
    
    /**
     * @param string $pageTitle
     * @param array $modalFieldInfo
     * @param array $data
     * @param array $actions
     * @return string
     */
    public static function generateDynamicTable(
        string $pageTitle,
        array $modalFieldInfo,
        array $data,
        array $actions = []
    ): string {
        ob_start();
        include __DIR__ . '/../views/head.php';
        $head = ob_get_clean();
        include __DIR__ . '/../views/topnav.php';
        $topnav = ob_get_clean();
    
        $itemName = static::$itemName;
        $ucItemName = ucfirst($itemName);
        
        $output = "<html lang=\"en\">
<head>
    <title>{$pageTitle}</title>
    <link rel=\"stylesheet\" href=\"/css/char-edit.css\">
    " . $head . '
</head>
<body>' . $topnav;
        
        
    
    
    }
    
    protected static function writeToFile($saveData, string $hexOffset, string $hexValue)
    {
        $handle = $saveData;
        $hexValue = strlen($hexValue) == 1 ? '0' . $hexValue : $hexValue;
        if (!is_resource($saveData)) {
            $handle = fopen('php://memory', 'rb+');
            fwrite($handle, $saveData);
        }
        
        fseek($handle, hexdec($hexOffset));
        fwrite($handle, hex2bin($hexValue));
        rewind($handle);
        
        return $handle;
    }
    
    protected static function numberConvertEndian($number, $byteSize)
    {
        $hexChars = $byteSize * 2;
        $data = dechex((float)$number);
        
        $data = str_pad($data, $hexChars, '0', STR_PAD_LEFT);
        
        $unpack = unpack('H*', strrev(pack('H*', $data)));
        
        return strtoupper($unpack[1]);
    }
    
    protected static function stringToHex($string)
    {
        $output = "";
        foreach (mb_str_split($string) as $char) {
            $char = self::uniord($char);
            if ($char > 255) {
                $char = self::numberConvertEndian($char, 2);
            } else {
                $char = dechex($char);
            }
            $output .= sprintf('%02s', strtoupper($char));
        }
        
        return $output;
    }
    
    protected static function uniord($u)
    {
        $k = mb_convert_encoding($u, 'SJIS', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        
        return $k2 * 256 + $k1;
    }
    
    protected static function arrayOfModelsToCSVDownload($records)
    {
        if (count($records)) {
            $handle = fopen('php://memory', 'w');
    
            /*
             * Really really smelly cheese to get names of protected properties!
             */
            fputcsv($handle, array_map(fn($value) => ltrim(substr($value, 2)), array_keys((array)$records[0])));
            foreach ($records as $record) {
                $data = (array)$record;
                foreach ($data as &$field) {
                    if ($field instanceof \DateTime) {
                        $field = $field->format('Y-m-d H:i');
                    } elseif (is_resource($field)) {
                        $field = strtoupper(bin2hex(stream_get_contents($field)));
                    }
                }
                fputcsv($handle, $data);
            }
            
            rewind($handle);
            ResponseService::SendDownloadResource($handle, static::$itemName . '.csv');
        }
    }
    
    /**
     * @param string $deleteWhere
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected static function importFromCSV(string $deleteWhere = '1=1'): void
    {
        $lines = preg_split('/\r\n|\r|\n/', file_get_contents($_FILES[static::$itemClass . 'CSV']["tmp_name"]));
        $attributes = str_getcsv($lines[0]);
        unset($lines[0]);
        $em = EM::getInstance();
        foreach ($lines as $line) {
            if ($line == "") {
                continue;
            }
            
            $lineValues = str_getcsv($line);
            $item = new static::$itemClass();
            foreach ($attributes as $key => $attribute) {
                $setter = "set" . implode('', array_map('ucfirst', explode('_', $attribute)));
                $item->$setter($lineValues[$key]);
            }
            $em->persist($item);
        }
        
        $em->createQuery('delete from ' . static::$itemClass . ' n where ' . $deleteWhere)->execute();
        $em->flush();
        
        ResponseService::SendOk();
    }
    
    /**
     * @return void
     * @throws ORMException
     */
    protected static function SaveItem(callable $callback): void
    {
        $item = new static::$itemClass();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $item = EM::getInstance()->getRepository(static::$itemClass)->find($_POST['id']);
        } else {
            $highestId = EM::getInstance()->getRepository(static::$itemClass)->matching(
                Criteria::create()->orderBy(['id' => 'desc']))->first();
            if (!empty($highestId)) {
                $item->setId($highestId->getId() + 1);
            } else {
                $item->setId(1);
            }
        
            EM::getInstance()->persist($item);
        }
        
        $callback($item);
    
        EM::getInstance()->flush();
    
        ResponseService::SendOk($item->getId());
    }
}
