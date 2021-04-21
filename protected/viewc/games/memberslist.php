<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$isApproved = ($user) ? MainHelper::IsPlayerApproved($user->ID_PLAYER) : 1;
$suspendLevel = ($user) ? $user->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$nick = PlayerHelper::showName($user);
$rank = PlayerHelper::showRank($user);
echo 'hello world this is the memberslist';
?>