<h3><?php echo $this->__('Companies'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/companies');?>"><?php echo $this->__('All Companies');?></a>
	</li>
        <?php foreach($companyTypes as $type): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('admin/companies/'.$type->ID_COMPANYTYPE);?>">
                    <?php
                        if(!empty($type->TypeNameTranslated)) echo $type->TypeNameTranslated;
                        else echo $type->CompanyTypeName;
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/companies/new');?>"><?php echo $this->__('New Company');?></a>
	</li>
</ul>
<h3><?php echo $this->__('Company Types'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/companies/types');?>"><?php echo $this->__('All Company Types');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/companies/types/new');?>"><?php echo $this->__('New Company Type');?></a>
	</li>
</ul>