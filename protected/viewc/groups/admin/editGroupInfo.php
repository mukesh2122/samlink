<?php
	$Form = new FormBuilder();
        $Form->AddHidden('group_id', $group->ID_GROUP);
        $Form->AddTitle($this->__('Edit Group Info'));
        $Form->AddTextInput('groupName', $this->__('Group Name'), null, 'group_name', $group->GroupName, 'group_name');
        if (!empty($members)) {
            $Options = array();
            foreach ($members as $member) {
                $Temp = new FormOption($member->ID_PLAYER, PlayerHelper::showName($member), isset($member->SnPlayerGroupRel) && $member->SnPlayerGroupRel[0]->isLeader);
                $Options[] = $Temp->Get();
            }
            $Form->AddSelectInput('groupLeader', $this->__('Group Leader'), $Options, null, 'group_leader');
        }
        $groupType1Options = array();
        $groupType2Options = array();
        foreach ($group_types as $type) {
            switch ($type->Subtype) {
                case 1:
                    $Temp = new FormOption($type->ID_GROUPTYPE, $type->GroupTypeName, $type->ID_GROUPTYPE == $group->ID_GROUPTYPE1);
                    $groupType1Options[] = $Temp->Get();
                    break;
                case 2:
                    $Temp = new FormOption($type->ID_GROUPTYPE, $type->GroupTypeName, $type->ID_GROUPTYPE == $group->ID_GROUPTYPE2);
                    $groupType2Options[] = $Temp->Get();
                    break;
            }
        }
        $Form->AddSelectInput('groupType1', $this->__('Type 1'), $groupType1Options, null, 'group_type1');
        $Form->AddSelectInput('groupType2', $this->__('Type 2'), $groupType2Options, null, 'group_type2');
        $Form->AddTextfield('groupDescription', $this->__('Group Description'), $group->GroupDesc);
        $Form->AddPicture("Group", "group", $group, $group->ID_GROUP);
	$Form->Show();
?>