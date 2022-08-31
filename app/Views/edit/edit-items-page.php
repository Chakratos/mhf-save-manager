<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-box" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $UILocale['Itembox']?></a>
        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-pouch" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo $UILocale['Pouch']?></a>
        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-ammopouch" role="tab" aria-controls="nav-contact" aria-selected="false"><?php echo $UILocale['Ammo Pouch']?></a>
        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-warehouse" role="tab" aria-controls="nav-contact" aria-selected="false"><?php echo $UILocale['Warehouse']?></a>
    </div>
</nav>
<div class="row">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-box" role="tabpanel" aria-labelledby="nav-box-tab">
            <?php include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-itembox-nav.php';?>
        </div>
        <div class="tab-pane fade" id="nav-pouch" role="tabpanel" aria-labelledby="nav-pouch-tab">
            ...<?php //include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-pouch-page.php';?>
        </div>
        <div class="tab-pane fade" id="nav-ammopouch" role="tabpanel" aria-labelledby="nav-ammopouch-tab">
            ...<?php //include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-ammopouch-page.php';?>
        </div>
        <div class="tab-pane fade" id="nav-warehouse" role="tabpanel" aria-labelledby="nav-warehouse-tab">...</div>
    </div>
</div>
