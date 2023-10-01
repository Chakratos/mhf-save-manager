<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-equip-box" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $UILocale['Equipment Box']?></a>
    </div>
</nav>
<div class="row">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-equip-box" role="tabpanel" aria-labelledby="nav-box-tab">
            <?php include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-equipbox-nav.php';?>
        </div>
    </div>
</div>
