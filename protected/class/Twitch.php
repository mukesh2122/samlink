<?php
class Twitch {
	public function getAllChannels() {
        $channels = Doo::db()->find('SyChannels');
        return $channels;
    }

    public function getChannelByTwitchName($name) {
        $channels = new SyChannels();
        $channel = Doo::db()->getOne('SyChannels',array(
            'where' => "{$channels->_table}.TwitchName = '{$name}'",
            'limit' => 1
        ));
        return $channel;
    }

    public function getSortedChannels() {
        $channels = self::getAllChannels();
        $channelList = array();
        $onlineChannels = array();
        $featureChannels = array();
        $offlineChannels =array();
        $favoriteChannels = array();
        $onlineCount = 0;
        $offlineCount = 0;

        $feature = self::getChannelByTwitchName('riotgames');
        $default = TRUE;

        if(!$feature->isLive()) {
            foreach($channels as $channel) {
                if($channel->isLive()){
                    $onlineChannels[] = $channel;
                    $onlineCount++;
                    if($default == TRUE || $channel->TotalViews > $feature->TotalViews) {
                       $feature = $channel;
                       $default = FALSE;
                    };
                } else {
                    $offlineChannels[] = $channel;
                    $offlineCount++;
                };
                if($channel->FeatureChannel == 1) {
                    $featureChannels[] = $channel;
                };
                if($channel->isFavorite()) {
                    $favoriteChannels[] = $channel;
                };
            };
        } else {
            foreach($channels as $channel) {
                if($channel->isLive()) {
                    $onlineChannels[] = $channel;
                    $onlineCount++;
                } else {
                    $offlineChannels[] = $channel;
                    $offlineCount++;
                };
                if($channel->FeatureChannel == 1) {
                    $featureChannels[] = $channel;
                };
                if($channel->isFavorite()) {
                    $favoriteChannels[] = $channel;
                };
            };
        };

        $channelList['startChannel'] = $feature;
        $channelList['featureChannels'] = $featureChannels;
        $channelList['onlineChannels'] = $onlineChannels;
        $channelList['offlineChannels'] = $offlineChannels;
        $channelList['favoriteChannels'] = $favoriteChannels;
        $channelList['onlineCount'] = $onlineCount;
        $channelList['offlineCount'] = $offlineCount;
        return $channelList;
    }

    public function setFavorite($channel, $player, $remove) {
        $pc = new SyPlayerChannelRel();

        $pc->FK_CHANNEL = $channel;
        $pc->FK_PLAYER = $player;

        if($remove == "true") {
            $favorite = $pc->getOne();
            if(!empty($favorite))
                $favorite->delete();
        } else {
            $pc->insert();
        };
    }
}
?>