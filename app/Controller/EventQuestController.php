<?php

namespace MHFSaveManager\Controller;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\EventQuest;
use MHFSaveManager\Service\EditorGeneratorService;
use MHFSaveManager\Service\UIService;

/**
 *
 */
class EventQuestController extends AbstractController
{
    protected static string $itemName = 'eventquest';
    protected static string $itemClass = EventQuest::class;
    
    /**
     * @return void
     */
    public static function Index(): void
    {
        $UILocale = UIService::getForLocale();
        $data = [];
        
        $modalFieldInfo = [
            $UILocale['ID']          => [
                'type'     => 'Hidden',
                'disabled' => true,
            ],
            $UILocale['Quest ID']    => ['type' => 'Int'],
            $UILocale['Max Players'] => ['type' => 'Int', 'min' => 1, 'max' => 4, 'placeholder' => '1-4'],
            $UILocale['Quest Type']  => [
                'type'    => 'Array',
                'options' => EventQuest::$quest_types,
            ],
            $UILocale['Mark']        => [
                'type'    => 'Array',
                'options' => EventQuest::$quest_marks,
            ],
        ];
        
        $fieldPositions = [
            'headline' => $UILocale['ID'],
            [
                $UILocale['Quest ID'],
                $UILocale['Max Players'],
                $UILocale['Quest Type'],
                $UILocale['Mark'],
            ],
        ];
        
        $eventQuests = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        
        /** @var EventQuest $eventQuest */
        foreach ($eventQuests as $eventQuest) {
            $questTypeName = EventQuest::$quest_types[$eventQuest->getQuestType()] ?? 'Unknown';
            $questMarkName = EventQuest::$quest_marks[$eventQuest->getMark()] ?? 'Unknown';
            
            $data[] = [
                $UILocale['ID']          => $eventQuest->getId(),
                $UILocale['Quest Type']  =>
                    [
                        'id'   => $eventQuest->getQuestType(),
                        'name' => '[' . $eventQuest->getQuestType() . '] ' . $questTypeName,
                    ],
                $UILocale['Mark']        =>
                    [
                        'id'   => $eventQuest->getMark(),
                        'name' => '[' . $eventQuest->getMark() . '] ' . $questMarkName,
                    ],
                $UILocale['Quest ID']    => $eventQuest->getQuestId(),
                $UILocale['Max Players'] => $eventQuest->getMaxPlayers(),
            ];
        }
        
        $actions = [
        ];
        
        echo EditorGeneratorService::generateDynamicTable('MHF Event Quests', static::$itemName, $modalFieldInfo,
            $fieldPositions, $data, $actions);
    }
    
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function EditEventQuest(): void
    {
        self::SaveItem(static function (EventQuest $eventQuest) {
            $eventQuest->setQuestId($_POST[self::localeWS('Quest ID')]);
            $eventQuest->setQuestType($_POST[self::localeWS('Quest Type')]);
            $eventQuest->setMaxPlayers($_POST[self::localeWS('Max Players')]);
            $eventQuest->setMark($_POST[self::localeWS('Mark')]);
        });
    }
    
    /**
     * @return void
     */
    public static function ExportEventQuests(): void
    {
        $records = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        
        self::arrayOfModelsToCSVDownload($records);
    }
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function ImportEventQuests(): void
    {
        self::importFromCSV();
    }
}
