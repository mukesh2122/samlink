<?php
if(isset($stats) and !empty($stats)):?>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_60 centered"><?php echo 'Balance';?></th>
                <th class="size_20 centered"><?php echo 'Coins';?></th>
                <th class="size_20 centered"><?php echo 'Credits';?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>User Accounts</td>
                <td class="centered">
                    <?php
                    $CoinsTotal = 0;
                    $CreditsTotal = 0;
                    
                    $Coins = doo::db()->fetchRow('SELECT SUM(Credits) AS sum FROM sn_players WHERE isDeleted=0');
                    echo $Coins['sum'];
                    
                    $CoinsTotal = $CoinsTotal+$Coins['sum'];
                    ?>
                </td>
                <td class="centered">
                    <?php
                    $Credits = doo::db()->fetchRow('SELECT SUM(PlayCredits) AS sum FROM sn_players WHERE isDeleted=0');
                    echo ($Credits['sum'] == ''? 0:$Credits['sum']);
                    
                    $CreditsTotal = $CreditsTotal+$Credits['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>E-Sport Accounts</td>
                <td class="centered">
                    <?php
                    $Coins = doo::db()->fetchRow('SELECT SUM(Balance) AS sum FROM es_accounts_credits WHERE OwnerType="team"');
                    echo ($Coins['sum'] == ''? 0:$Coins['sum']);
                    
                    $CoinsTotal = $CoinsTotal+$Coins['sum'];
                    ?>
                </td>
                <td class="centered">
                    <?php
                    $Credits = doo::db()->fetchRow('SELECT SUM(Balance) AS sum from es_accounts_coins WHERE OwnerType="team"');
                    echo ($Credits['sum'] == ''? 0:$Credits['sum']);
                    
                    $CreditsTotal = $CreditsTotal+$Credits['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>E-Sport Live</td>
                <td class="centered">
                    <?php
                    $Coins = doo::db()->fetchRow('SELECT SUM(Balance) AS sum FROM es_accounts_credits WHERE OwnerType="league"');
                    echo ($Coins['sum'] == ''? 0:$Coins['sum']);
                    
                    $CoinsTotal = $CoinsTotal+$Coins['sum'];
                    ?>
                </td>
                <td class="centered">
                    <?php
                    $Credits = doo::db()->fetchRow('SELECT SUM(Balance) AS sum from es_accounts_coins WHERE OwnerType="league"');
                    echo ($Credits['sum'] == ''? 0:$Credits['sum']);
                    
                    $CreditsTotal = $CreditsTotal+$Credits['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="centered"><?php echo $CoinsTotal; ?></td>
                <td class="centered"><?php echo $CreditsTotal; ?></td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_60 centered"><?php echo 'Ingoing';?></th>
                <th class="size_20 centered"><?php echo 'Coins';?></th>
                <th class="size_20 centered"><?php echo 'Credits';?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>User Cash-In</td>
                <td class="centered">
                </td>
                <td class="centered">
                <?php
                    $CoinsTotal = 0;
                    
                    $Coins = $stats->userCash();
                    echo $Coins;
                    
                    $CoinsTotal = $CoinsTotal+$Coins;
                ?>
                </td>
            </tr>
            <tr>
                <td>System Cash-In</td>
                <td class="centered">
                </td>
                <td class="centered">
                    <?php
                    $Coins = doo::db()->fetchRow('SELECT valueBool FROM sy_settings WHERE ID_SETTING="SystemCashIn"');
                    echo $Coins['valueBool'];
                    
                    $CoinsTotal = $CoinsTotal+$Coins['valueBool'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>Commission</td>
                <td class="centered"></td>
                <td class="centered">
                    <?php
                    $Coins = doo::db()->fetchRow('SELECT SUM(Credits) AS sum FROM sn_referrals WHERE Credits<>0');
                    echo $Coins['sum'];
                    
                    $CoinsTotal = $CoinsTotal+$Coins['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="centered"></td>
                <td class="centered"><?php echo $CoinsTotal; ?></td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_60 centered"><?php echo 'Outgoing';?></th>
                <th class="size_20 centered"><?php echo 'Coins';?></th>
                <th class="size_20 centered"><?php echo 'Credits';?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Shop (Not memberships)</td>
                <td class="centered"></td>
                <td class="centered">
                    <?php
                    $CoinsTotal = 0;
                    $CreditsTotal = 0;
                    
                    $Credits = doo::db()->fetchRow('SELECT SUM(TotalPrice) AS sum FROM fi_purchases WHERE ProductType<>"package" AND TotalPrice<>0');
                    echo $Credits['sum'];
                    
                    $CreditsTotal = $CreditsTotal+$Credits['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>E-Sport Fees</td>
                <td class="centered">
                    <?php
                    $Coins = doo::db()->fetchRow('SELECT SUM(Balance) AS sum FROM es_accounts_credits WHERE FK_OWNER=0 AND OwnerType="rake"');
                    echo ($Coins['sum'] == ''? 0:$Coins['sum']);
                    
                    $CoinsTotal = $CoinsTotal+$Coins['sum'];
                    ?>
                </td>
                <td class="centered">
                    <?php
                    $Credits = doo::db()->fetchRow('SELECT SUM(Balance) AS sum FROM es_accounts_coins WHERE FK_OWNER=0 AND OwnerType="rake"');
                    echo ($Credits['sum'] == ''? 0:$Credits['sum']);
                    
                    $CreditsTotal = $CreditsTotal+$Credits['sum'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>User Cash-Out</td>
                <td class="centered">
                </td>
                <td class="centered">
                <?php
                    $Credits = $stats->userCash('out');
                    echo $Credits;
                    
                    $CreditsTotal = $CreditsTotal+$Credits;
                ?>
                </td>
            </tr>
            <tr>
                <td>System Cash-Out</td>
                <td class="centered"></td>
                <td class="centered">
                    <?php
                    $Credits = doo::db()->fetchRow('SELECT valueBool FROM sy_settings WHERE ID_SETTING="SystemCashOut"');
                    echo $Credits['valueBool'];
                    
                    $CreditsTotal = $CreditsTotal+$Credits['valueBool'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="centered"><?php echo $CoinsTotal; ?></td>
                <td class="centered"><?php echo $CreditsTotal; ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>