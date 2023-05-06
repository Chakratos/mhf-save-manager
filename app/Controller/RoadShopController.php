<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\ShopItem;
use MHFSaveManager\Service\EditorGeneratorService;
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
        
        $data = [];
        
        $roadItems = EM::getInstance()->getRepository(self::$itemClass)->matching(
            Criteria::create()->where(Criteria::expr()->eq('shop_type', '10'))
        )->toArray();
        
        $modalFieldInfo = [
            $UILocale['ID']                   => [
                'type'     => 'Hidden',
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
    
        $fieldPositions = [
            'headline' => $UILocale['ID'],
            [
                $UILocale['Category'],
                $UILocale['Item'],
            ],
            [
                $UILocale['Cost'],
                $UILocale['GRank Req'],
                $UILocale['Trade Quantity'],
                $UILocale['Maximum Quantity'],
                $UILocale['Road Floors Req'],
                $UILocale['Weekly Fatalis Kills'],
            ],
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
/*                'NestedModalData' => [
                    $UILocale['Items'] => [
                        1 => [$UILocale['Cost'] => 12, $UILocale['GRank Req'] => 34],
                        2 => [$UILocale['Cost'] => 34, $UILocale['GRank Req'] => 56],
                    ],
                ]*/
            ];
        }
        
        $actions = [
        ];
        
        echo EditorGeneratorService::generateDynamicTable('MHF Road Shop', static::$itemName, $modalFieldInfo, $fieldPositions, $data, $actions);
    }
    
    
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function EditRoadShopItem(): void
    {
        self::SaveItem(static function ($item) {
            $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST[self::localeWS('Item')]), 2)));
            $item->setMaxQuantity($_POST[self::localeWS('Maximum Quantity')]);
            $item->setQuantity($_POST[self::localeWS('Trade Quantity')]);
            $item->setMinGr($_POST[self::localeWS('GRank Req')]);
            $item->setCost($_POST[self::localeWS('Cost')]);
            $item->setShopid($_POST[self::localeWS('Category')]);
            $item->setRoadFloors($_POST[self::localeWS('Road Floors Req')]);
            $item->setRoadFatalis($_POST[self::localeWS('Weekly Fatalis Kills')]);
    
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
