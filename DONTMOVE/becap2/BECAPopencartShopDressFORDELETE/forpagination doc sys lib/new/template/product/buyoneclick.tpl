<!-- Button oneclick -->

<div class="form-group form-one-click-call">
    <!--<label class="control-label" for="input-telephone">
        <?php //$text_buyoneclick_phone ?>
    </label> -->
    <div class="row">
        <div class="col-xs-7">
            <input type="tel" name="telephone" value="" id="input-telephone"
                   class="form-control" style="margin-right: 0" placeholder="<?= $text_buyoneclick_phone ?>" maxlength="30"/>

        </div>
        <div class="col-xs-5">

            <button type="button" id="button-oneclick" data-loading-text="<?php echo $text_loading; ?>"
                    class="btn btn-success btn-tel btn-block"><?= $text_buy_one_click ?></button>
        </div>

    </div>

    <div style="display: none;">

        <div class="wrong_number"><?=$text_wrong_number?></div>

    </div>


</div>
