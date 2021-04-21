
--------------------------------------------------------

--
-- 
Struktur-dump for tabellen `sy_banners`

--


CREATE TABLE IF NOT EXISTS `sy_banners` (
  `ID_BANNER` int(11) NOT NULL AUTO_INCREMENT,
  `Placement` varchar(50) NOT NULL,
  `isCode` int(11) DEFAULT NULL,
  `Code` text NOT NULL,
  `PathToBanner` varchar(200) NOT NULL,
  `DestinationUrl` text NOT NULL,
  `MaxDisplays` int(11) DEFAULT NULL,
  `CurrentDisplays` int(11) DEFAULT NULL,
  `MaxClicks` int(11) DEFAULT NULL,
  `CurrentClicks` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_BANNER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- 
--------------------------------------------------------

--
-- 
Struktur-dump for tabellen `sy_campaignbanner_rel`
--

CREATE TABLE IF NOT EXISTS `sy_campaignbanner_rel` (
  `ID_CAMPAIGN` int(11) NOT NULL,
  `ID_BANNER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 
--------------------------------------------------------

--
-- 
Struktur-dump for tabellen `sy_campaigncountry_rel`
--

CREATE TABLE IF NOT EXISTS `sy_campaigncountry_rel` (
  `ID_CAMPAIGN` int(11) NOT NULL,
  `ID_BANNER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 
--------------------------------------------------------

--
-- 
Struktur-dump for tabellen `sy_campaigns`
--

CREATE TABLE IF NOT EXISTS `sy_campaigns` (
  `ID_CAMPAIGN` int(11) NOT NULL AUTO_INCREMENT,
  `AdvertiserName` varchar(50) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `isAllTerritories` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CAMPAIGN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


--
-- 
Data dump for tabellen `sy_campaigns`
--

INSERT INTO `sy_campaigns` (`ID_CAMPAIGN`, `AdvertiserName`, `StartDate`, `EndDate`, `isAllTerritories`) VALUES
(1, 'test1', '2013-03-05', '2013-03-31', 1),
(2, 'test2', '2013-03-05', '2013-03-31', 1),
(3, 'test', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
