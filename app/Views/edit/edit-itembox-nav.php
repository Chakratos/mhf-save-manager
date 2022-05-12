<style>
    .carousel-indicators > li {
        background-color: #999;
    }
    .item-col {
        height: 79px;
        width: 117px;
    }

</style>

<div id="itemboxSlotEdit" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemboxSlotEditTitle">Editing Itemslot: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6>Item:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="itemboxSlotItem">
                        <?php
                        foreach (\MHFSaveManager\Service\ItemsService::$items as $id => $item) {
                            printf('<option data-icon="%s" data-color="%s" value="%s">%s</option>', $item['icon'], $item['color'], $id, $item['name']);
                        }
                        ?>
                    </select>
                </div>
                
                <h6>Quantity:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="itemboxSlotQuantity" placeholder="999" min="1" max="999">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="itemboxSlotSave">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="itemboxPagination" class="carousel slide" data-interval="false" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#itemboxPagination" data-slide-to="0" class="active"></li>
        <?php
        for ($i = 0; $i < count($itembox) / 100 -1; $i++) {
            printf('<li data-target="#itemboxPagination" data-slide-to="%s"></li>', $i+1);
        }
        ?>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            $itemCount = 0;
            $rowCount = 0;
            $pageCount = 0;
            foreach ($itembox as $item) {
                if ($itemCount == 0) {
                    echo '<div class="row item-row">';
                }
                $tmpItem = \MHFSaveManager\Service\ItemsService::$items[$item->getId()];
                printf('
                            <div class="col item-col" data-id="%s" data-quantity="%s" data-slot="%s">
                                <img class="item-icon" src="/img/item/%s%s.png">
                                <span style="font-size: 12px;"><b>[x%s]</b><br>%s</span>
                            </div>',
                    $item->getId(),
                    $item->getQuantity(),
                    $item->getSlot(),
                    $tmpItem['icon'],
                    $tmpItem['color'],
                    $item->getQuantity(),
                    ucwords(implode(' ',preg_split('/(?=[A-Z][^A-Z][^A-Z])/', $item->getName())))
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
                    if (count($itembox) > $pageCount*100) {
                        echo '<div class="carousel-item">';
                    }
                }
            }
            ?>
    </div>
    <a class="carousel-control-prev" href="#itemboxPagination" role="button" style="width: auto; background-color: black; height: 15%; margin-top: 25%;" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#itemboxPagination" role="button" style="width: auto; background-color: black; height: 15%; margin-top: 25%;" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <br>
    <h3 id="slidetext" style="  top: -25px;position: relative;"></h3>
</div>
