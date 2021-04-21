<?php
class Stats{
    /**
     * Returns total referrers info
     * 
     * @return int
     */
    public function referrersTotalStats()
    {
        $query = '
        SELECT
            RecordType AS name,
            COUNT(1) AS count
        FROM
            sn_referrals
        GROUP BY
            RecordType
        ORDER BY
            RecordType
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns all referrers users referrers info
     * 
     * @param int $id
     * @return int
     */
    public function referrersList($limit,$order='desc',$searchText = '')
    {
        $query = '
        SELECT
            sn_players.FirstName AS name,
            sn_players.lastName AS nameLast,
            sn_players.DisplayName AS DisplayName,
            sn_players.ID_PLAYER AS id,
            SUM( IF( sn_referrals.RecordType = "click", 1, 0 ) ) AS click,
            SUM( IF( sn_referrals.RecordType = "signup", 1, 0 ) ) AS signup,
            SUM( IF( sn_referrals.RecordType = "payment", 1, 0 ) ) AS payment,
            SUM(sn_referrals.Credits) AS sum
        FROM
            sn_referrers
         LEFT JOIN
             sn_referrals
         ON
             sn_referrals.VoucherCode = sn_referrers.VoucherCode
         LEFT JOIN
             sn_players
         ON
             sn_referrers.ID_REFERRER = sn_players.ID_PLAYER
         '.($searchText==''?'':'WHERE sn_players.DisplayName LIKE "%'.$searchText.'%"').'
        GROUP BY
            sn_referrers.ID_REFERRER
        ORDER BY
             name '.$order.'
        LIMIT '.$limit.'
        ';
        return Doo::db()->fetchAll($query);
    }
    public function referrersCount($searchText = '')
    {
        $query = '
        SELECT
            COUNT(DISTINCT(ID_REFERRER))  AS count
        FROM
            sn_referrers
         LEFT JOIN
             sn_players
         ON
             sn_referrers.ID_REFERRER = sn_players.ID_PLAYER
        '.($searchText==''?'':'WHERE sn_players.DisplayName LIKE "%'.$searchText.'%"').'
        ';
        $return = Doo::db()->fetchRow($query);
        return $return['count'];
    }
    
    /**
     * Returns referrers info from user id
     * 
     * @param int $id
     * @return int
     */
    public function referrersPlayerInfo($id)
    {
        $query = '
        SELECT
            sn_players.FirstName AS name,
            sn_players.lastName AS nameLast,
            sn_players.DisplayName AS DisplayName,
            sn_players.ID_PLAYER AS id,
            SUM( IF( sn_referrals.RecordType = "click", 1, 0 ) ) AS click,
            SUM( IF( sn_referrals.RecordType = "signup", 1, 0 ) ) AS signup,
            SUM( IF( sn_referrals.RecordType = "payment", 1, 0 ) ) AS payment,
            SUM(sn_referrals.Credits) AS sum
        FROM
            sn_referrers
         LEFT JOIN
             sn_referrals
         ON
             sn_referrals.VoucherCode = sn_referrers.VoucherCode
        WHERE 
            sn_referrers.ID_REFERRER = '.$id.'
        GROUP BY
            sn_referrers.ID_REFERRER
        ';
        return Doo::db()->fetchRow($query);
    }
    /**
     * Returns all sub referrers info from id
     * 
     * @param int $id
     * @return int
     */
    public function playerSubReferrers($id)
    {
        $query = '
        SELECT
            sn_players.FirstName AS name,
            sn_players.lastName AS nameLast,
            sn_players.DisplayName AS DisplayName,
            sn_players.ID_PLAYER AS id,
            SUM( IF( sn_referrals.RecordType = "click", 1, 0 ) ) AS click,
            SUM( IF( sn_referrals.RecordType = "signup", 1, 0 ) ) AS signup,
            SUM( IF( sn_referrals.RecordType = "payment", 1, 0 ) ) AS payment,
            SUM(sn_referrals.Credits) AS sum
        FROM
            sn_referrers
         LEFT JOIN
             sn_referrals
         ON
             sn_referrals.VoucherCode = sn_referrers.VoucherCode
         LEFT JOIN
             sn_players
         ON
             sn_referrers.ID_REFERRER = sn_players.ID_PLAYER
        WHERE 
            sn_referrers.ID_PARENT = '.$id.'
         AND
             sn_referrers.ID_REFERRER <> '.$id.'
        GROUP BY
            sn_referrers.ID_REFERRER
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns total sum of commission
     * 
     * @return int
     */
    public function commissionSum()
    {
        $query = '
        SELECT
            SUM(Credits) AS sum
        FROM
            sn_referrals
        WHERE
            Credits<>0
        ';
        $return = Doo::db()->fetchRow($query);
        return $return['sum'];
    }
    
    
    
    /**
     * Returns page news stats
     *
     * @return Array
     */
    public function newsCount(){
        $query = '
        SELECT
            ge_languages.EnglishName AS name,
            SUM( IF( nw_items.OwnerType = "game", 1, 0 ) ) AS game,
            SUM( IF( nw_items.OwnerType = "company", 1, 0 ) ) AS company,
            SUM( IF( nw_items.OwnerType = "group", 1, 0 ) ) AS groups,
            COUNT(1) AS count
        FROM
            ge_languages
        INNER JOIN
            nw_itemlocales
        ON
            ge_languages.ID_LANGUAGE = nw_itemlocales.ID_LANGUAGE
           INNER JOIN
               nw_items
           ON
               nw_itemlocales.ID_NEWS = nw_items.ID_NEWS
         GROUP BY
            ge_languages.EnglishName
         ORDER BY
            count
         DESC
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns page games stats
     *
     * @return Array
     */
    public function gamesCount(){
        $query = '
        SELECT
            sn_gametypes.GameTypeName AS name,
            COUNT(sn_games.ID_GAME) AS count
        FROM
            sn_gametypes
        LEFT JOIN
            sn_games
        ON
            sn_gametypes.ID_GAMETYPE = sn_games.ID_GAMETYPE
         GROUP BY
            GameTypeName
         ORDER BY
            count
         DESC
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns page companies stats
     *
     * @return Array
     */
    public function companiesCount(){
        $query = '
        SELECT
            sn_companytypes.CompanyTypeName AS name,
            COUNT(sn_companies.ID_COMPANY) AS count
        FROM
            sn_companytypes
        LEFT JOIN
            sn_companies
        ON
            sn_companytypes.ID_COMPANYTYPE = sn_companies.ID_COMPANYTYPE
         GROUP BY
            sn_companytypes.CompanyTypeName
         ORDER BY
            count
         DESC
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns page groups stats
     *
     * @return Array
     */
    public function groupsCount(){
        $query = '
        SELECT
            sn_groups.GroupType2 AS name,
            SUM( IF( sn_groups.GroupType1 = "PVE", 1, 0 ) ) AS pve,
            SUM( IF( sn_groups.GroupType1 = "PVP", 1, 0 ) ) AS pvp,
            SUM( IF( sn_groups.GroupType1 = "RP", 1, 0 ) ) AS rp,
            COUNT(sn_groups.ID_GROUP) AS count
        FROM
            sn_groups
        GROUP BY
            sn_groups.GroupType2
        ORDER BY
            name
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns page events stats
     *
     * @return Array
     */
    public function eventsCount(){
        $query = '
        SELECT
            ev_events.EventType AS name,
            SUM( IF( ev_events.ID_GAME <> 0, 1, 0 ) ) AS games,
            SUM( IF( ev_events.ID_COMPANY <> 0, 1, 0 ) ) AS companies,
            SUM( IF( ev_events.ID_GROUP <> 0, 1, 0 ) ) AS groups
        FROM
            ev_events
        GROUP BY
            ev_events.EventType
        ';
        return Doo::db()->fetchAll($query);
    }
    
    
    
    /**
     * Returns user memberships types count
     *
     * @return Array
     */
    public function userMembershipsTypes(){
        $query = '
            SELECT
                fi_playerpackage_rel.PackageType AS name,
                COUNT(1) AS count
            FROM
                fi_playerpackage_rel
             WHERE
                 fi_playerpackage_rel.PackageType <> ""
             AND
                 fi_playerpackage_rel.ActivationTime < UNIX_TIMESTAMP()
             AND
                 fi_playerpackage_rel.ExpirationTime > UNIX_TIMESTAMP()
            GROUP BY
                fi_playerpackage_rel.PackageType
            ORDER BY
                name
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns countries user count
     *
     * @return Array
     */
    public function usersCountry(){
        $query = '
        SELECT
            ge_countries.Country AS name,
            COUNT(sn_players.ID_LANGUAGE) AS count
        FROM
            ge_countries
        INNER JOIN
            sn_players
        ON
            ge_countries.A2 = sn_players.Country
        WHERE
            sn_players.isDeleted=0
         GROUP BY
            ge_countries.Country
         ORDER BY
            count
         DESC
        ';
        return Doo::db()->fetchAll($query);
    }
    /**
     * Returns languages user count
     *
     * @return Array
     */
    public function usersLanguage(){
        $query = '
        SELECT
            ge_languages.EnglishName AS name,
            COUNT(sn_players.ID_LANGUAGE) AS count
        FROM
            ge_languages
        INNER JOIN
            sn_players
        ON
            ge_languages.ID_LANGUAGE = sn_players.ID_LANGUAGE
        WHERE
            sn_players.isDeleted=0
        GROUP BY
            ge_languages.EnglishName
        ORDER BY
            count
        DESC
        ';
        return Doo::db()->fetchAll($query);
    }
    
    /**
     * Returns get user between DateOfBirth
     *
     * @param Int timestamp $fromDate
     * @param Int timestamp $toDate
     * @return Int
     */
    public function birthBetween2Dates($fromDate = '0000-00-00',$toDate = ''){
        $return = doo::db()->fetchRow('
        SELECT
            COUNT(1) AS count
        FROM
            sn_players
        WHERE
            '.($toDate==''?'
            DateOfBirth = "'.$fromDate.'"
            ':'
            DateOfBirth
                BETWEEN
                    "'.$fromDate.'"
                AND
                    "'.$toDate.'"
            ').'
        AND
            isDeleted=0
        ');
        return $return['count'];
    }
    
    /**
     * Returns user activity
     *
     * @return Array
     */
    public function userActivity(){
        $wallItems = doo::db()->fetchAll('
        SELECT
            sn_wallitems.ItemType AS name,
            COUNT(1) AS count
        FROM
            sn_wallitems
        GROUP BY
            sn_wallitems.ItemType
        ORDER BY
            name
        DESC
        ');
        
        $subscription = doo::db()->fetchAll('
        SELECT
            sn_playersubscription_rel.ItemType AS name,
            COUNT(1) AS count
        FROM
            sn_playersubscription_rel
        GROUP BY
            sn_playersubscription_rel.ItemType
        ORDER BY
            name
        DESC
        ');
        
        return array_merge($wallItems,$subscription);
    }
    /**
     * Returns intro steps stats
     *
     * @return Array
     */
    public function introSteps(){
        $query = '
        SELECT
            IntroSteps AS id,
            SUM( IF( IntroSteps = 0, 1, 0) ) AS step0,
            SUM( IF( IntroSteps = 1, 1, 0) ) AS step1,
            SUM( IF( IntroSteps = 2, 1, 0) ) AS step2,
            SUM( IF( IntroSteps = 3, 1, 0) ) AS step3,
            SUM( IF( IntroSteps = 4, 1, 0) ) AS step4
        FROM
            sn_players
        WHERE
            isDeleted=0
        AND
            VerificationCode = ""
        ';
        
        return doo::db()->fetchRow($query);
    }
    /**
     * Returns get users cash
     *
     * @param String $type in/out 
     * @return Array
     */
    public function userCash($type = 'in'){
        $query = '
        SELECT
            ID_PAYMENT,
            PaymentProvider,
            PaymentText
        FROM
            fi_payments
        WHERE
            PaymentType = "'.$type.'"
        AND
            PaymentPrice = 0
        ';
        $NoPaymentValue = doo::db()->fetchAll($query);
        
        foreach($NoPaymentValue as $k => $v)
        {
            $PaymentArray = unserialize($v['PaymentText']);
            if($v['PaymentProvider'] == 'paypal')
            {
                if(isset($PaymentArray['amount']))
                {
                    $amount = $PaymentArray['amount'];
                }
                
            }
            elseif (isset($PaymentArray['amount']))
            {
                $amount = $PaymentArray['amount'];
            }
            elseif(isset($PaymentArray['out']))
            {
                $amount = $PaymentArray['out'];
            }
            else
            {
                if(isset($PaymentArray['out'])){
                    $amount = $PaymentArray['out'];
                }
            }
            
            if(isset($amount))
            {
                doo::db()->query('UPDATE fi_payments SET PaymentPrice='.$amount.' WHERE ID_PAYMENT='.$v['ID_PAYMENT']);
            }
        }
        
        $query = '
        SELECT
            SUM(PaymentPrice) AS sum
        FROM
            fi_payments
        WHERE
            PaymentType = "'.$type.'"
        ';
        
        $return = doo::db()->fetchRow($query);
        return $return['sum'];
    }
}
?>