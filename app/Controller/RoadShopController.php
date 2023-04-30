<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\ShopItem;
use MHFSaveManager\Service\ResponseService;
use MHFSaveManager\Service\ItemsService;
use MHFSaveManager\Service\UIService;

/**
 *
 */
class RoadShopController extends AbstractController
{
    
    protected static string $itemName = 'roadshop';
    protected static string $itemClass = ShopItem::class;
    /**
     * @return void
     */
    public static function Index(): void
    {
        $UILocale = UIService::getForLocale();
        $itemName = self::$itemName;
        $data = [];
        
        $roadItems = EM::getInstance()->getRepository(self::$itemClass)->matching(
            Criteria::create()->where(Criteria::expr()->eq('shop_type', '10'))
        )->toArray();
        
        $modalFieldInfo = [
            $UILocale['ID']                   => [
                'type'     => 'Int',
                'disabled' => true,
            ],
            $UILocale['Category']             => [
                'type'    => 'Array',
                'options' => ShopItem::$categories,
            ],
            $UILocale['Item']                 => [
                'type'    => 'Array',
                'options' => ItemsService::getForLocale(),
            ],
            $UILocale['Cost']                 => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['GRank Req']            => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['Trade Quantity']       => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['Maximum Quantity']     => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['Road Floors Req']      => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['Weekly Fatalis Kills'] => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
        ];
        
        foreach ($roadItems as $roadItem) {
            $itemId = self::numberConvertEndian($roadItem->getItemid(), 2);
            $itemData = ItemsService::getForLocale()[$itemId];
            $data[] = [
                $UILocale['ID']                   => $roadItem->getId(),
                $UILocale['Category']             =>
                    [
                        'id'   => $roadItem->getShopid(),
                        'name' => $roadItem->getShopidFancy(),
                    ],
                $UILocale['Item']                 =>
                    [
                        'id'   => $itemId,
                        'name' => $itemData['name'] ? : $UILocale['No Translation!'],
                    ],
                $UILocale['Cost']                 => $roadItem->getCost(),
                $UILocale['GRank Req']            => $roadItem->getMinGr(),
                $UILocale['Trade Quantity']       => $roadItem->getQuantity(),
                $UILocale['Maximum Quantity']     => $roadItem->getMaxQuantity(),
                $UILocale['Road Floors Req']      => $roadItem->getRoadFloors(),
                $UILocale['Weekly Fatalis Kills'] => $roadItem->getRoadFatalis(),
            ];
        }
        
        $actions = [
        ];
        
        echo self::generateDynamicTable('MHF Character Manager', $modalFieldInfo, $data, $actions);
    }
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function EditRoadShopItem(): void
    {
        self::SaveItem(static function ($item) {
            $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST['item']), 2)));
            $item->setMaxQuantity($_POST['maximumquantity']);
            $item->setQuantity($_POST['tradequantity']);
            $item->setMinGr($_POST['grankreq']);
            $item->setCost($_POST['cost']);
            $item->setShopid($_POST['category']);
            $item->setRoadFloors($_POST['roadfloorsreq']);
            $item->setRoadFatalis($_POST['weeklyfataliskills']);
    
            $item->setShoptype(10);
            $item->setMinHr(0);
            $item->setMinSr(0);
            $item->setStoreLevel(1);
        });
    }
    
    /**
     * @return void
     */
    public static function ExportRoadShopItems(): void
    {
        
        $records = EM::getInstance()->getRepository(self::$itemClass)->matching(
            Criteria::create()->where(Criteria::expr()->eq('shop_type', '10')));
        
        self::arrayOfModelsToCSVDownload($records);
    }
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function ImportRoadShopItems(): void
    {
        self::importFromCSV('n.shop_type = 10');
    }
}
