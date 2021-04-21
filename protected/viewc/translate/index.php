<?php
    $name = ($OrigObj["Name"] === $transName) ? "" : $transName;
    $desc = ($OrigObj["Desc"] === $transDesc) ? "" : $transDesc;
?>
<article id="T_translationPage">
    <section>
        <header>
            <h2><?php echo $this->__("Original"); ?></h2>
        </header>

        <div>
            <label for="T_origName"><?php echo $this->__("Original name"); ?></label>
            <input id="T_origName" name="T_origName" class="RSinputControls" readonly="readonly" type="text" maxlength="255" placeholder="<?php echo $transName; ?>">
        </div>

        <div>
            <label for="T_origDesc"><?php echo $this->__("Original description"); ?></label>
            <?php echo MainHelper::loadCKE("T_origDesc", $transDesc, array("readOnly" => TRUE, "removePlugins" => "maxlength,resize", "extraPlugins" => "autogrow", "autoGrow_onStartup" => TRUE)); ?>
        </div>
    </section>

    <section>
        <header>
            <h2><?php echo $this->__("Translation to"); ?>
                <select id="T_language" class="dropkick_lightNarrow">
                    <option value="<?php echo $langID; ?>" selected="selected"><?php echo $langName; ?></option>
                    <?php for($i = 0; $i < $iEnd; ++$i) {
                        $tmpLang = Lang::getLangById($otherLangs[$i]);
                        $tmpName = $tmpLang->NativeName;
                        if($tmpName !== $langName) { echo '<option value="' . $tmpLang->A2 . '">' . $tmpName . '</option>'; };
                    }; ?>
                </select>
            </h2>
        </header>

        <div>
            <label for="T_transName"><?php echo $this->__("Translated name"); ?></label>
            <input id="T_transName" name="T_transName" class="RSinputControls" type="text" maxlength="255" placeholder="<?php echo $name; ?>">
        </div>

        <div>
            <label for="T_transDesc"><?php echo $this->__("Translated description"); ?></label>
            <?php echo MainHelper::loadCKE("T_transDesc", $desc, array("removePlugins" => "resize", "extraPlugins" => "autogrow,maxlength", "autoGrow_onStartup" => TRUE), array("textareaAttributes" => array("maxlength" => 60000))); ?>
        </div>
    </section>

    <button id="T_saveButton" class="RSbuttons"><?php echo $this->__("Save translation"); ?></button>
</article>