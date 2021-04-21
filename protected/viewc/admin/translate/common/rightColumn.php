<h3><?php echo 'Admin menu'; ?></h3>
<ul class="vertical_tabs">
    <li>
        <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/package/lang/' . $translate->A2); ?>"
           <?php echo (isset($rightmenuselect) && ($rightmenuselect == "LngGroup" || $rightmenuselect == "Languages")) ? 'class="selected"' : ''; ?>>
               <?php echo 'Groups'; ?>
        </a>

        <?php
        if (!isset($grouptype)) {
            $grouptype = "";
        }
        ?>

        <?php if (isset($rightmenuselect) && ($rightmenuselect == "LngGroup" || $rightmenuselect == "Languages")) { ?>

            <ul class="vertical_tabs_indent">
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/' . $translate->A2); ?>"
                       <?php echo (isset($rightmenuselect) && $rightmenuselect == "Languages") ? 'class="selected"' : ''; ?>>
                           <?php echo 'Texts'; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/package/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "package") ? 'class="selected"' : ''; ?>>Packages</a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/menu/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "menu") ? 'class="selected"' : ''; ?>>Menu</a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/producttype/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "producttype") ? 'class="selected"' : ''; ?>>Producttype</a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/companytype/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "companytype") ? 'class="selected"' : ''; ?>>Companytype</a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/gametype/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "gametype") ? 'class="selected"' : ''; ?>>Gametype</a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/info/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "info") ? 'class="selected"' : ''; ?>>Info</a>
                </li>
                 <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/lnggroup/prefix/lang/' . $translate->A2); ?>"
                       <?php echo ($grouptype == "prefix") ? 'class="selected"' : ''; ?>>Prefix</a>
                </li>
            </ul>
        <?php } ?>


    </li>

    <li>
        <a href="<?php echo MainHelper::site_url('admin/translate/keycontent/lang/' . $translate->A2); ?>"
           <?php echo (isset($rightmenuselect) && $rightmenuselect == "KeyContent") ? 'class="selected"' : ''; ?>>
               <?php echo 'Key content'; ?>
        </a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/translate/dllang/lang/' . $translate->A2); ?>"
           <?php echo (isset($rightmenuselect) && $rightmenuselect == "DlLang") ? 'class="selected"' : ''; ?>>
               <?php echo 'Download language'; ?>
        </a>
    </li>




    <!--	<li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/new'); ?>"
    <?php echo (isset($rightmenuselect) && $rightmenuselect == "NewLanguage") ? 'class="selected"' : ''; ?>>
    <?php echo 'New language'; ?>
                    </a>
            </li>
            <li>
                    <a href="<?php echo MainHelper::site_url('admin/translate/deletelanguage'); ?>"
    <?php echo (isset($rightmenuselect) && $rightmenuselect == "DeleteLanguage") ? 'class="selected"' : ''; ?>>
    <?php echo 'Delete language'; ?>
                    </a>
            </li>-->
</ul>


