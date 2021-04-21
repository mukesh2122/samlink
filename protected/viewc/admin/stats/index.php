<?php
//SQL
/*
ALTER TABLE `fi_payments`
ADD COLUMN `PaymentPrice` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `ID_PLAYER`;
*/
if(isset($stats) and !empty($stats)):?>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_20 centered"><?php echo 'News';?></th>
                <th class="size_20 centered"><?php echo 'Games';?></th>
                <th class="size_20 centered"><?php echo 'Companies';?></th>
                <th class="size_20 centered"><?php echo 'Groups';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>
        
        <tbody>
        <?php
        foreach($stats->newsCount() as $key => $value)
        {
                echo '
                <tr>
                    <td class="centered">'.$value['name'].'</td>
                    <td class="centered">'.$value['game'].'</td>
                    <td class="centered">'.$value['company'].'</td>
                    <td class="centered">'.$value['groups'].'</td>
                    <td class="centered">'.$value['count'].'</td>
                </tr>
                ';
        }
        ?>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'Games';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach($stats->gamesCount() as $key => $value)
        {
            echo '
            <tr>
                <td>'.$value['name'].'</td>
                <td class="right">'.$value['count'].'</td>
            </tr>
            ';
        }
        ?>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'Companies';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach($stats->companiesCount() as $key => $value)
        {
            echo '
            <tr>
                <td>'.$value['name'].'</td>
                <td class="right">'.$value['count'].'</td>
            </tr>
            ';
        }
        ?>
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_20 centered"><?php echo 'Groups';?></th>
                <th class="size_20 centered"><?php echo 'PVE';?></th>
                <th class="size_20 centered"><?php echo 'PVP';?></th>
                <th class="size_20 centered"><?php echo 'RP';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
            foreach($stats->groupsCount() as $key => $value)
            {
                echo '
                <tr>
                    <td class="centered">'.$value['name'].'</td>
                    <td class="centered">'.$value['pve'].'</td>
                    <td class="centered">'.$value['pvp'].'</td>
                    <td class="centered">'.$value['rp'].'</td>
                    <td class="centered">'.$value['count'].'</td>
                </tr>';
            }
        ?>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_20 centered"><?php echo 'Events';?></th>
                <th class="size_20 centered"><?php echo 'Games';?></th>
                <th class="size_20 centered"><?php echo 'Companies';?></th>
                <th class="size_20 centered"><?php echo 'Groups';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
            <tr>
        <?php
            foreach($stats->eventsCount() as $key => $value)
            {
                echo '
                <tr>
                    <td class="centered">'.ucfirst($value['name']).'</td>
                    <td class="centered">'.$value['games'].'</td>
                    <td class="centered">'.$value['companies'].'</td>
                    <td class="centered">'.$value['groups'].'</td>
                    <td class="centered">'.($value['games']+$value['companies']+$value['groups']).'</td>
                </tr>';
            }
        ?>
        </tbody>
    </table>
<?php endif; ?>
