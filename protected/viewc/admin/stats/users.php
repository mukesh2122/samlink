<?php
if(isset($stats) and !empty($stats)):?>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_20 centered"><?php echo 'Basic';?></th>
                <th class="size_20 centered"><?php echo 'Silver';?></th>
                <th class="size_20 centered"><?php echo 'Gold';?></th>
                <th class="size_20 centered"><?php echo 'Platinum';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td class="centered">
                <?php
                    $packagesCount=0;
                    $memberships = '';
                    foreach($stats->userMembershipsTypes() as $key => $value)
                    {
                        switch($value['name'])
                        {
                            case'Silver':
                                $silver = $value['count'];
                            break;
                            case'Gold':
                                $gold = $value['count'];
                            break;
                            case'Platinum':
                                $platinum = $value['count'];
                            break;
                        }
                        $packagesCount = $packagesCount+$value['count'];
                    }
                
                    
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE IntroSteps=4 AND isDeleted=0');
                    $basic = ($allUsers['count']-$packagesCount);
                    echo $basic;
                    
                    $packagesCount = $packagesCount+$basic;
                ?>
                </td>
                <?php
                echo '
                <td class="centered">'.$silver.'</td>
                <td class="centered">'.$gold.'</td>
                <td class="centered">'.$platinum.'</td>
                ';
                ?>
                <td class="centered"><?php echo $packagesCount; ?></td>
            </tr>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'Countries';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach($stats->usersCountry() as $key => $value)
        {
            echo '
            <tr>
                <td class="size_80">'.$value['name'].'</td>
                <td class="size_20 right">'.$value['count'].'</td>
            </tr>
            ';
        }
        ?>
            <tr>
                <td class="size_80">Unknown</td>
                <td class="size_20 right">
                <?php
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE Country="" AND isDeleted=0');
                    echo $allUsers['count'];
                ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'Lanuages';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach($stats->usersLanguage() as $key => $value)
        {
            echo '
            <tr>
                <td class="size_80">'.$value['name'].'</td>
                <td class="size_20 right">'.$value['count'].'</td>
            </tr>
            ';
        }
        ?>
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'Ages';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="size_80">0 - 9 years</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates((date('Y',time())-9).date('-m-d',time()), (date('Y',time())-0).date('-m-d',time()));
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">10 - 17 years</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates((date('Y',time())-17).date('-m-d',time()), (date('Y',time())-10).date('-m-d',time()));
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">18 - 29 years</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates((date('Y',time())-29).date('-m-d',time()), (date('Y',time())-18).date('-m-d',time()));
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">30 - 49 years</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates((date('Y',time())-49).date('-m-d',time()), (date('Y',time())-30).date('-m-d',time()));
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">50+ years</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates((date('Y',time())-50).date('-m-d',time()), '1800-01-01');
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Unknown</td>
                <td class="size_20 right">
                <?php
                    echo $stats->birthBetween2Dates();
                ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_80"><?php echo 'First Time Users';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td class="size_80">Registration</td>
                <td class="size_20 right">
                <?php
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE isDeleted=0');
                    echo $allUsers['count'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Not activated</td>
                <td class="size_20 right">
                <?php
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE VerificationCode<>"" AND isDeleted=0');
                    echo $allUsers['count'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Activation</td>
                <td class="size_20 right">
                <?php
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE VerificationCode="" AND isDeleted=0');
                    echo $allUsers['count'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Login</td>
                <td class="size_20 right">
                <?php
                    $allUsers = doo::db()->fetchRow('SELECT COUNT(1) AS count FROM sn_players WHERE LastActivity<>"" AND isDeleted=0');
                    echo $allUsers['count'];
                ?>
                </td>
            </tr>
            <?php
            $steps = $stats->introSteps();
            ?>
            <tr>
                <td class="size_80">Introduction: step 1</td>
                <td class="size_20 right">
                <?php
                    echo $steps['step0'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Introduction: step 2</td>
                <td class="size_20 right">
                <?php
                    echo $steps['step1'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Introduction: step 3</td>
                <td class="size_20 right">
                <?php
                    echo $steps['step2'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Introduction: step 4</td>
                <td class="size_20 right">
                <?php
                    echo $steps['step3'];
                ?>
                </td>
            </tr>
            <tr>
                <td class="size_80">Has completed introduction</td>
                <td class="size_20 right">
                <?php
                    echo $steps['step4'];
                    
                    //set user count
                    $userCount = $steps['step4'];
                ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_60"><?php echo 'User Activity';?></th>
                <th class="size_20 centered"><?php echo 'Per User';?></th>
                <th class="size_20 centered"><?php echo 'Total';?></th>
            </tr>
        </thead>

        <tbody>
        <?php
        $totalCount = 0;
        foreach($stats->userActivity() as $key => $value)
        {
            echo '
            <tr>
                <td>'.($value['name'] == 'photo'?'Images':ucfirst($value['name'])).'</td>
                <td class="right">
                '.round($value['count']/$userCount,2).'
                </td>
                <td class="right">
                '.$value['count'].'
                </td>
            </tr>
            ';
            $totalCount = $totalCount + $value['count'];
        }
        ?>
        <tr>
            <td>Total</td>
            <td class="right">
            <?php
                echo round($totalCount/$userCount,2);
            ?>
            </td>
            <td class="right">
            <?php
                 echo $totalCount;
            ?>
            </td>
        </tr>
    </tbody>
</table>
<?php endif; ?>
