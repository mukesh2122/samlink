<?php include('common/top.php'); ?> 

<div class="clearfix mt8 pr" id="get_contacts_cont">
    <div class="fl no-margin"><input id="gmail" value="gmail" class="cp" name="mail_system" type="radio" checked="checked"/> <label class="cp" for="gmail">GMail</label></div>
    <div class="fl"><input id="hotmail" value="hotmail" class="cp" name="mail_system" type="radio"/> <label class="cp" for="hotmail">Hotmail</label></div>
    <div class="fl"><input id="yahoo" value="yahoo" class="cp" name="mail_system" type="radio"/> <label class="cp" for="yahoo">Yahoo Mail</label></div>
    <div class="clear">&nbsp;</div>
    <div class="comments-cont mt10">
        <div class="comments-top">
              <div class="comments-bot clearfix pr">
                <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Username');?>:</span>
                <span class="fl db"><input name="user" id="mail_username" value="" /></span>
              </div>
        </div>
    </div>
    <div class="comments-cont mt10">
        <div class="comments-top">
              <div class="comments-bot clearfix pr">
                <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Password');?>:</span>
                <span class="fl db"><input name="user" id="mail_password" value="" /></span>
              </div>
        </div>
    </div>
    <div class="clear mt10">&nbsp;</div>
    <a class="get_mail_contacts fft fr link_green" href="javascript:void(0)"><span><span><?php echo $this->__('Get Contacts');?></span></span></a>
</div>

<div class="clearfix dot_bot mt8 pr">
    <div class="grid_5 alpha mt6 mb10">
        <a class="fs10 mr20" id="select_all" href="javascript:void(0)"><?php echo $this->__('Select All');?></a>
        <a class="fs10 mr20 dn" id="deselect_all" href="javascript:void(0)"><?php echo $this->__('Deselect All');?></a>
        <a class="fs10 mr20 delete_selected_messages" href="javascript:void(0)"><?php echo $this->__('Invite Selected');?></a>
    </div>
</div>

<div id="contact_list" class="clearfix mt10">
    
    
</div>
<script type="text/javascript">loadCheckboxes();</script>