<div class="row">
    <div class="border border-dark rounded col-3 py-2">
        <h6>Zenny:</h6>
        <div class="input-group mb-2">
            <input id="zenny" type="text" class="form-control" placeholder="0" value="<?php echo $zenny ?>">
            <div class="input-group-append">
                <div id="setzenny" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>gZenny:</h6>
        <div class="input-group mb-2">
            <input id="gzenny" type="text" class="form-control" placeholder="0" value="<?php echo $gZenny ?>">
            <div class="input-group-append">
                <div id="setgzenny" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>GCP:</h6>
        <div class="input-group mb-2">
            <input id="gcp" type="text" class="form-control" placeholder="0" value="<?php echo $gcp ?>">
            <div class="input-group-append">
                <div id="setgcp" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>NPoints:</h6>
        <div class="input-group mb-2">
            <input id="npoints" type="text" class="form-control" placeholder="0" value="<?php echo $npoints ?>">
            <div class="input-group-append">
                <div id="setnpoints" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>Frontier Points:</h6>
        <div class="input-group mb-2">
            <input id="frontierpoints" type="text" class="form-control" placeholder="0" value="<?php echo $frontierPoints ?>">
            <div class="input-group-append">
                <div id="setfrontierpoints" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>Kouryou Points:</h6>
        <div class="input-group mb-2">
            <input id="kouryou" type="text" class="form-control" placeholder="0" value="<?php echo $kouryou ?>">
            <div class="input-group-append">
                <div id="setkouryou" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>Gacha Trial:</h6>
        <div class="input-group mb-2">
            <input id="gachatrial" type="text" class="form-control" placeholder="0" value="<?php echo $gachaTrial ?>">
            <div class="input-group-append">
                <div id="setgachatrial" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>

        <h6>Gacha Prem:</h6>
        <div class="input-group mb-2">
            <input id="gachaprem" type="text" class="form-control" placeholder="0" value="<?php echo $gachaPrem ?>">
            <div class="input-group-append">
                <div id="setgachaprem" class="input-group-text btn btn-success text-white bg-success"><i class="fa fa-save"></i></div>
            </div>
        </div>
    </div>

    <div class="border border-dark rounded col-3 py-2">
        <div class="input-group">
            <label>
                Style Vouchers:
            </label>
            <input id="stylevouchers" type="hidden" placeholder="0" value="99">
            <button id="setstylevouchers" class="btn btn-success w-100">Set to 99</button>
        </div>
    
        <div class="input-group">
            <label>
                Daily Guild Reward:
            </label>
            <button id="resetdailyguild" class="btn btn-success w-100">Reset</button>
        </div>
    
        <div class="input-group">
            <label>
                Login Boost:
            </label>
            <button id="resetloginboost" class="btn btn-success w-100">Reset</button>
        </div>
    </div>
</div>
