<div id="equipboxSlotEdit" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="equipboxSlotEditTitle"><?php use MHFSaveManager\Model\Equip;
    
                    echo $UILocale['Editing Itemslot']?>: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6><?php echo $UILocale['Item']?>:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="equipboxSlotItem">
                        <option>NOT YET IMPLEMENTED!!</option>
                    </select>
                </div>

                <h6><?php echo $UILocale['Quantity']?>:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="equipboxSlotQuantity" placeholder="999" min="1" max="999">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $UILocale['Close']?></button>
                <button type="button" class="btn btn-primary" id="equipboxSlotSave"><?php echo $UILocale['Save']?></button>
            </div>
        </div>
    </div>
</div>

<div id="equipboxPagination" class="carousel slide" data-interval="false" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#equipboxPagination" data-slide-to="0" class="active"></li>
        <?php
        for ($i = 0; $i < count($equipbox) / 100 -1; $i++) {
            printf('<li data-target="#equipboxPagination" data-slide-to="%s"></li>', $i+1);
        }
        ?>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            $itemCount = 0;
            $rowCount = 0;
            $pageCount = 0;
            /** @var Equip[] $equipbox */
            foreach ($equipbox as $item) {
                if ($itemCount == 0) {
                    echo '<div class="row item-row">';
                }
                
                printf('
                            <div class="col item-col" data-id="%s" data-slot="%s">
                                <img class="item-icon" src="/img/equip/%s/%s.png">
                                <span style="font-size: 12px;"><b>[lvl %s]</b><br>%s</span>
                            </div>',
                    $item->getId(),
                    $item->getSlot(),
                    $item->getType() < 6 ? 'armor' : 'weapon',
                    $item->getType() < 6 ? \MHFSaveManager\Service\EquipService::$types[$item->getType()] : $item->getWeaponType(),
                    $item->getUpgradeLevel(),
                    implode(' ',preg_split('/(?=[A-Z][^A-Z][^A-Z])/', $item->getName()))
                );
                if (++$itemCount >= 10) {
                    echo '</div>';
                    $itemCount = 0;
                    $rowCount++;
                }
                if ($rowCount >= 10) {
                    echo '</div>';
                    $rowCount = 0;
                    $itemCount = 0;
                    $pageCount++;
                    if (count($equipbox) > $pageCount*100) {
                        echo '<div class="carousel-item">';
                    }
                }
            }
            if ($itemCount < 10 && $itemCount > 0) {
                echo '</div>';
            }

            if ($rowCount < 10 && $rowCount > 0) {
                echo '</div>';
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#equipboxPagination" role="button" style="width: auto; background-color: black; height: 15%; margin-top: 25%;" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#equipboxPagination" role="button" style="width: auto; background-color: black; height: 15%; margin-top: 25%;" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <br>
        <h3 id="slidetext"></h3>
    </div>
