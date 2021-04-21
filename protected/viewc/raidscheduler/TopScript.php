<script type="text/javascript">
    var GroupPage = false;
    <?php if(isset($group)): ?>
        var GroupPage = true,
        GroupID = <?php echo $group->ID_GROUP; ?>,
        GroupMember = <?php if($group->isMember()) { echo "true"; } else { echo "false"; }; ?>,
        GroupOfficer = <?php if($group->isOfficer()) { echo "true"; } else { echo "false"; }; ?>,
        GroupCreator = <?php if($group->isCreator()) { echo "true"; } else { echo "false"; }; ?>,
        GroupAdmin = <?php if($group->isAdmin()) { echo "true"; } else { echo "false"; }; ?>;
    <?php endif; ?>
</script>