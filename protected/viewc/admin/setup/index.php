<div id="admin_setup_tree">
	<ul>
		<!-- Main modules -->
		<?php foreach($modules as $module):
			if(($module["dependID"] == 0) && ($module["isEnabled"] == 1 || $superadmin)): ?>
				<li class="module" name="<?php echo $module["ID_MODULE"]; ?>">
					<a class="<?php echo ($module['isEnabled'] ? 'jstree-clicked' : ''), ' ', ($module['isDefault'] ? 'isDefault' : ''); ?>"
					 href="<?php echo $player->canAccess("module_".$module["ModuleTag"]) ? MainHelper::site_url("admin/setup/editmodule/id/".$module["ID_MODULE"]) : ''; ?>">
						<?php echo $this->__($module["ModuleTitle"]), " (", $this->__($module["ModuleName"]), ")"; ?>
					</a>
					<ul>
						<?php foreach($modules as $firstchild):
							
							//-- First child functions --
							foreach($firstchild["functions"] as $modfuncs):
								if($modfuncs["ID_MODULE"] === $module["ID_MODULE"]): ?>
									<li class="function" name="<?php echo $modfuncs['ID_MODFUNC']; ?>">
										<a class="<?php echo ($modfuncs['isEnabled'] ? 'jstree-clicked' : ''), ' ', ($modfuncs['isDefault'] ? 'isDefault' : ''); ?>">
											<?php echo $this->__($modfuncs["FunctionTitle"]), " (", $this->__($modfuncs["FunctionName"]), ")"; ?>
										</a>
									</li>
								<?php endif;
							endforeach;
							
							//-- First child modules --
							if($firstchild["dependID"] === $module["ID_MODULE"]): ?>
								<li class="module" name="<?php echo $firstchild["ID_MODULE"]; ?>">
									<a class="<?php echo ($firstchild['isEnabled'] ? 'jstree-clicked' : ''), ' ', ($firstchild['isDefault'] ? 'isDefault' : ''); ?>"
									 href="<?php echo $player->canAccess("module_".$firstchild["ModuleTag"]) ? MainHelper::site_url("admin/setup/editmodule/id/".$firstchild["ID_MODULE"]) : ''; ?>">
										<?php echo $this->__($firstchild["ModuleTitle"]), " (", $this->__($firstchild["ModuleName"]), ")"; ?>
									</a>
									<ul>
										<?php foreach($modules as $secondchild):
											
											//-- Second child functions --
											foreach($secondchild["functions"] as $modfuncs):
												if($modfuncs["ID_MODULE"] === $firstchild["ID_MODULE"]): ?>
													<li class="function" name="<?php echo $modfuncs['ID_MODFUNC']; ?>">
														<a class="<?php echo ($modfuncs['isEnabled'] ? 'jstree-clicked' : ''), ' ', ($modfuncs['isDefault'] ? 'isDefault' : ''); ?>">
															<?php echo $this->__($modfuncs["FunctionTitle"]), " (", $this->__($modfuncs["FunctionName"]), ")"; ?>
														</a>
													</li>
												<?php endif;
											endforeach;
											
											//-- Second child modules --
											if($secondchild["dependID"] === $firstchild["ID_MODULE"]): ?>
												<li class="module" name="<?php echo $secondchild["ID_MODULE"]; ?>">
													<a class="<?php echo ($secondchild['isEnabled'] ? 'jstree-clicked' : ''), ' ', ($secondchild['isDefault'] ? 'isDefault' : ''); ?>"
													 href="<?php echo $player->canAccess("module_" . $secondchild["ModuleTag"]) ? MainHelper::site_url("admin/setup/editmodule/id/".$secondchild["ID_MODULE"]) : ''; ?>">
														<?php echo $this->__($secondchild["ModuleTitle"]), " (", $this->__($secondchild["ModuleName"]), ")"; ?>
													</a>
												</li>
											<?php endif;
										endforeach; ?>
									</ul>
								</li>
							<?php endif;
						endforeach; ?>
					</ul>
				</li>
			<?php endif;
		endforeach; ?>
	</ul>
</div>

<?php if ($superadmin): ?>
	<button class="button button_auto light_blue mt18" id="admin_setup_submit"><?php echo $this->__("Save Settings"); ?></button>
<?php endif; ?>
<?php include(Doo::conf()->SITE_PATH . 'global/js/adminsetuptree.js.php'); ?>
