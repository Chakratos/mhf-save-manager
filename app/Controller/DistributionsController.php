<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Distribution;
use MHFSaveManager\Model\DistributionItem;
use MHFSaveManager\Service\ItemsService;
use MHFSaveManager\Service\ResponseService;

class DistributionsController extends AbstractController
{
    public static function Index()
    {
        $distributions = EM::getInstance()->getRepository('MHFSaveManager\Model\Distribution')->findAll();
        $characters = \MHFSaveManager\Database\EM::getInstance()->getRepository('MHFSaveManager\Model\Character')->findAll();
        
        
        include_once ROOT_DIR . '/app/Views/distributions.php';
    }
    
    public static function IndexTest()
    {
        $distributions = EM::getInstance()->getRepository('MHFSaveManager\Model\Distribution')->findAll();
    
        /** @var Distribution $distribution */
        foreach ($distributions as $distribution) {
            echo "<hr>";
            printf("Name: %s <br>", $distribution->getEventName());
            printf("Desc: %s <br>", $distribution->getDescription());
            printf("Type: %s <br>", Distribution::$types[$distribution->getType()]);
            echo "<br><b>Items:</b><br>";
            $data = $distribution->getData();
            $numberOfItems = hexdec(bin2hex(fread($data, 2)));
            
            for ($i = 0; $i < $numberOfItems; $i++) {
                $item = new DistributionItem(bin2hex(fread($data, 13)));
                printf("Reencoded hex value: %s<br>", $item);
                printf("ItemNr: %s <br>Type: %s <br>Item: %s <br>Amount: %s<br><br>", $i+1, DistributionItem::$types[$item->getType()], ItemsService::getForLocale()[$item->getItemId()]['name'], $item->getAmount());
                
            }
            
        }
        echo "<hr>";
    }
    
    public static function EditDistribution()
    {
        $distribution = new Distribution();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $distribution = EM::getInstance()->getRepository('MHFSaveManager\Model\Distribution')->find($_POST['id']);
        } else {
            EM::getInstance()->persist($distribution);
        }
        
        $distribution->setType($_POST['type']);
        $distribution->setCharacterId((int)$_POST['characterId']);
        $distribution->setTimesAcceptable((int)$_POST['timesacceptable']);
        $distribution->setEventName($_POST['name']);
        $distribution->setDescription($_POST['desc']);
        $distribution->setDeadline($_POST['deadline'] ? new \DateTime($_POST['deadline']) : null);
        $distribution->setMinHr((int)$_POST['minhr']);
        $distribution->setMaxHr((int)$_POST['maxhr']);
        $distribution->setMinSr((int)$_POST['minsr']);
        $distribution->setMaxSr((int)$_POST['maxsr']);
        $distribution->setMinGr((int)$_POST['mingr']);
        $distribution->setMaxGr((int)$_POST['maxgr']);
        
        $itemString = sprintf('%04X', count($_POST['items']));
        
        foreach ($_POST['items'] as $item) {
            $itemString .= (new DistributionItem())->setType((int)$item['type'])->setAmount((int)$item['amount'])->setItemId($item['itemId']);
        }
        $handle = fopen('php://memory', 'br+');
        fwrite($handle, hex2bin($itemString));
        rewind($handle);
        $distribution->setData($handle);
        
        EM::getInstance()->flush();
    
        ResponseService::SendOk();
        
    }
    
    public static function ExportDistributions()
    {
        $records = EM::getInstance()->getRepository('MHFSaveManager\Model\Distribution')->findAll();
        self::arrayOfModelsToCSVDownload($records, 'Distributions');
    }
    
    public static function ImportDistributions()
    {
        self::importFromCSV('distributionCSV', Distribution::class, 'delete from MHFSaveManager\Model\Distribution n where 1=1');
    }
}
