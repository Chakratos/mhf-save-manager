<div class="card my-2 card-body border-0 p-0" style="width: auto; height: 5rem">
    <div class="row h-100 align-items-center">
        <div class="col-auto">
            <img src="/img/equip/<?php printf("%s", $gear->isWeapon() ? "weapon/". $gear->getWeaponType() : "armor/" . $gear->getTypeAsString());  ?>.png" style="width: 3rem; height: 3rem;">
            <br>
            <span class="px-2"> Level <span class="font-weight-bold border border-dark rounded px-1"><?php echo $gear->getUpgradeLevel() ?></span></span>
        </div>
        <div class="col-5 my-auto">
            <h5><?php echo $gear->getName();  ?></h5>
        </div>
        <div class="col-sm my-auto mr-2">
            <?php
            foreach ($gear->getDecorations() as $deco) {
                echo sprintf('<input class="form-control form-control-sm my-1" style="height: 1.5rem;" disabled value="%s">', $deco->getName());
            }
            ?>
        </div>
    </div>
</div>
