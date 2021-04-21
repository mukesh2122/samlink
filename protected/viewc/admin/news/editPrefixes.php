<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
    <thead>
        <tr>            
            <th class="size_20"><?php echo $this->__('Prefix'); ?></th>
            <th class="size_20"><?php echo $this->__('Category'); ?></th>
            <th class="size_20 centered"><?php echo $this->__('Background'); ?></th>
            <th class="size_20 centered"><?php echo $this->__('Options'); ?></th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($prefixes as $prefix) { ?>
        <?php if ($prefix->ID_PREFIX == '1') {} else { ?>
        <form method="GET" id="prefixesForm" action="<?php echo MainHelper::site_url('admin/news/save-Prefixes'); ?>">
            <input name="prefixId" type="hidden" value="<?php echo $prefix->ID_PREFIX ?>"
                   <tr class="bg_choser2">            
                <td class="prefix_preview">
                    <div class="list_item_prefix" style="color:<?php echo $prefix->PrefixColor; ?>;">
                        <?php echo "[" . $prefix->PrefixName . "]"?>
                    </div>
                </td>
                <td class="centered"><input name ="prefixName" type="text" maxlength="8" size="8" value="<?php echo $prefix->PrefixName ?>"></td>
                <td class="centered"><input class="cp-basic2" name ="prefixColor" type="text" maxlength="8" size="8" value="<?php echo $prefix->PrefixColor ?>"></td>
                <td class="centered">
                    <input type="submit" name="submit" value="<?php echo $this->__('Save'); ?>">
                    &nbsp;&nbsp;&nbsp;
                    <input type="submit" name="submit" value="<?php echo $this->__('Delete'); ?>" onclick="return confirm('<?php echo $this->__('Are you sure?') ?>')" >
                </td>
            </tr>


        </form>
    
        <?php }} ?>
</tbody>
</table>

<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
    <tbody>
        <form method="GET" id="prefixesFormAdd" action="<?php echo MainHelper::site_url('admin/news/add-Prefixes'); ?>">
            <input name="prefixId" type="hidden" value=""
                   <tr class="bg_choser2">            
                <td class="prefix_preview size_20">
                    
                        <div class="list_item_prefix">
                        <?php echo "test" ?>
                    
                    </div>
                </td>
                <td class="centered size_20"><input name ="prefixName" type="text" maxlength="8" size="8" value=""></td>
                <td class="centered size_20"><input class="cp-basic2" name ="prefixColor" type="text" maxlength="8" size="8" value=""></td>
                <td class="centered size_20"><input type="submit" value="<?php echo $this->__('Add'); ?>"></td>
            </tr>


        </form>
    
</tbody>
</table>


