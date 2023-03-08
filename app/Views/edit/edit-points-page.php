<div class="row">
    <div class="border border-dark rounded col-3 py-2">
        <h6><?php echo $UILocale['Zenny']?>:</h6>
        <div class="input-group mb-2">
            <input id="zenny" type="text" class="form-control" placeholder="0" value="<?php echo $zenny ?>">
            <div class="input-group-append">
                <div id="setzenny" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6><?php echo $UILocale['gZenny']?>:</h6>
        <div class="input-group mb-2">
            <input id="gzenny" type="text" class="form-control" placeholder="0" value="<?php echo $gZenny ?>">
            <div class="input-group-append">
                <div id="setgzenny" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6><?php echo $UILocale['GCP']?>:</h6>
        <div class="input-group mb-2">
            <input id="gcp" type="text" class="form-control" placeholder="0" value="<?php echo $gcp ?>">
            <div class="input-group-append">
                <div id="setgcp" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6><?php echo $UILocale['NPoints']?>:</h6>
        <div class="input-group mb-2">
            <input id="npoints" type="text" class="form-control" placeholder="0" value="<?php echo $npoints ?>">
            <div class="input-group-append">
                <div id="setnpoints" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6><?php echo $UILocale['Kouryou Points']?>:</h6>
        <div class="input-group mb-2">
            <input id="kouryou" type="text" class="form-control" placeholder="0" value="<?php echo $kouryou ?>">
            <div class="input-group-append">
                <div id="setkouryou" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>
    </div>

    <div class="border border-dark rounded col-3 py-2">
        <div class="input-group">
            <label>
                <?php echo $UILocale['Style Vouchers']?>:
            </label>
            <input id="stylevouchers" type="hidden" placeholder="0" value="99">
            <button id="setstylevouchers" class="btn btn-success w-100"><?php echo $UILocale['Set to']?> 99</button>
        </div>
    
        <div class="input-group">
            <label>
                <?php echo $UILocale['Daily Guild Reward']?>:
            </label>
            <button id="resetdailyguild" class="btn btn-success w-100"><?php echo $UILocale['Reset']?></button>
        </div>
    
        <div class="input-group">
            <label>
                <?php echo $UILocale['Login Boost']?>:
            </label>
            <button id="resetloginboost" class="btn btn-success w-100"><?php echo $UILocale['Reset']?></button>
        </div>
    </div>
</div>
