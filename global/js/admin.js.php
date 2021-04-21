<script type="text/javascript">
    $(document).ready(function() {
        $('li.activate-li').on('click', function(e) {
            eatEvent(e);
            $(this).hide().next('li.show_dropdown-act').slideDown('slow');
        });

        $('a.close').on('click', function(e) {
            eatEvent(e);
            $(this).parent().slideUp('slow').prev().show();
        });

        $('button.rounded_gray-act').on('click', function(e) {
            eatEvent(e);
            var denne = this, url = '<?php echo MainHelper::site_url('admin/users/activate'); ?>/' + denne.getAttribute('ref');
            $.get(url, {}, function(data) {
                if(checkData(data) && (data === 'success')) {
                    $(denne.parentNode.parentNode).hide();
//                    $('ul.activate-ul').hide(); // see above, make sure it is the right grandparent and not all on the page
                    alert('Player activated!');
                } else { alert('Something went wrong!'); };
            });
        });
    }); 
</script>