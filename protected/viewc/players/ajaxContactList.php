<?php if(!empty($contacts)):?>
    <?php foreach ($contacts as $item):?>
    <?
        if(isset($item->Email)):
        $nick = $item->Name;
        $email = implode(', ', $item->Email);
    ?> 

    <div class="post_contact clearfix dot_bot">
        <div class="contact_inside mb10 pt10 clearfix">
            <div class="grid_1 alpha omega">
                <input id="c1" value="1" class="cp" type="checkbox"/>
            </div>
            <div class="grid_6 alpha omega">    
                <span class="fs10 fclg db"><?php echo $this->__('Contact');?>:</span>
                <span class="db mt0"><?php echo $nick;?></span>
                <span class="db mt0"><?php echo $email;?></span>
            </div>
        </div>
        
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>