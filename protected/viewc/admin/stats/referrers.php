<?php echo $this->renderBlock('admin/stats/common/search', array(
    'url' => MainHelper::site_url('admin/stats/referrers/search'),
    'searchText' => isset($searchText) ? $searchText : '',
    'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
    'label' => $label = 'Search for referrer stats...',
    'type' => $type = 'stats'
));

if(isset($stats) and !empty($stats)):
?>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_20 centered"><?php echo 'All referrers';?></th>
                <th class="size_20 centered"><?php echo 'Clicks';?></th>
                <th class="size_20 centered"><?php echo 'Sign-Ups';?></th>
                <th class="size_20 centered"><?php echo 'Upgrades';?></th>
                <th class="size_20 centered"><?php echo 'Commission';?></th>
            </tr>
        </thead>
            
        <tbody>
            <tr>
                <td class="size_20">Total</td>
                <?php
                foreach($stats->referrersTotalStats() as $key => $value)
                {
                    echo '<td class="size_20 centered">'.$value['count'].'</td>';
                }
                ?>
                <td class="size_20 centered">
                <?php
                echo $stats->commissionSum();
                ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    foreach($referrers_list as $key => $value):
    ?>
        <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
            <thead>
                <tr>
                    <th class="size_20 centered"><?php echo 'Playername';?></th>
                    <th class="size_20 centered"><?php echo 'Clicks';?></th>
                    <th class="size_20 centered"><?php echo 'Sign-Ups';?></th>
                    <th class="size_20 centered"><?php echo 'Upgrades';?></th>
                    <th class="size_20 centered"><?php echo 'Commission';?></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class=""><b><a href="<?php echo MainHelper::site_url('admin/users/edit/').$value['id'];?>"><?php echo ($value['name']!=''&&$value['nameLast']!=''?$value['name'].' '.$value['nameLast']:$value['DisplayName'])?></a></b></td>
                    <td class="centered"><?php echo $value['click'];?></td>
                    <td class="centered"><?php echo $value['signup'];?></td>
                    <td class="centered"><?php echo $value['payment'];?></td>
                    <td class="centered"><?php echo ($value['sum'] == ''?0:$value['sum']);?></td>
                </tr>
                
                <?php
                foreach($stats->playerSubReferrers($value['id']) as $k => $v):
                if($k == 0)
                {
                    echo '
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    ';
                }
                ?>
                <tr>
                    <td class=""><a href="<?php echo MainHelper::site_url('admin/users/edit/').$value['id'];?>"><?php echo ($v['name']!=''&&$v['nameLast']!=''?$v['name'].' '.$v['nameLast']:$v['DisplayName']);?></a></td>
                    <td class="centered"><?php echo $v['click'];?></td>
                    <td class="centered"><?php echo $v['signup'];?></td>
                    <td class="centered"><?php echo $v['payment'];?></td>
                    <td class="centered"><?php echo ($v['sum'] == ''?0:$v['sum']);?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endforeach;?>
<?php
if(isset($pager)){
    echo $this->renderBlock('common/pagination', array('pager'=>$pager));
}
endif;
?>
