<div class="row">
    <div class="border border-dark rounded col-8">
        <?php
        foreach ($currentGear as $gear) {
            include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-status.php';
            echo "<hr class='my-0'>";
        }
        ?>
    </div>
    <div class="col-1"></div>
    <div class="border border-dark rounded col-3 py-2">
        <h6><?php echo $UILocale['Name']?>:</h6>
        <div class="input-group mb-2">
            <input type="text" class="form-control" id="name" placeholder="Character Name" value="<?php echo $name ?>">
            <div class="input-group-append">
                <div id="setname" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>
        
        <h6><?php echo $UILocale['Keyquestflag']?>:</h6>
        <div class="input-group mb-2">
            <input id="keyquestflag" type="text" class="form-control" placeholder="0000000000000000" value="<?php echo $keyquestFlag ?>">
            <div class="input-group-append">
                <div id="setkeyquestflag" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>
    </div>
</div>
