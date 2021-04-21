<script type="text/javascript">
	$(document).ready(function() {
		$("#admin_setup_tree").jstree({
			"core" : {
				"multiple" : true,
				"themes" : {"icons" : false, "dots" : true, "stripes" : true},
				"expand_selected_onload" : false,
			},
			"checkbox" : {"visible" : true, "three_state" : false, "whole_node" : true, "keep_selected_style" : false},
			"plugins" : [ <?php echo '"search", "sort", "unique"', ($superadmin === TRUE) ? ', "checkbox"' : ''; ?> ] // "types", "unique"
		});
		$('#admin_setup_tree').on('changed.jstree', function(e, data) {
			switch (data.action) {
				case 'deselect_node' :
					//---- Disable all children modules and functions ----
					$('#admin_setup_tree').jstree('deselect_node', data.node.children);
					//---- Disable parent if no sibling is selecled ----
					var siblingSelected = false;
					var siblings = $('#admin_setup_tree').jstree('get_node', data.node.parent).children;
					for (var i = 0; i < siblings.length; ++i) {
						var sibling = $('#admin_setup_tree').jstree('get_node', siblings[i]);
						if (sibling.state.selected) {
							siblingSelected = true;
							break;
						}
					};
					if (!siblingSelected) {
						$('#admin_setup_tree').jstree('deselect_node', data.node.parent);
					}
					break;
				case 'select_node' :
					//---- Enable all children modules and functions ----
					var children = data.node.children;
					for (var i = 0; i < children.length; i++) {
						var child = $('#admin_setup_tree').jstree('get_node', children[i]);
						if (child.a_attr.class && child.a_attr.class.indexOf('isDefault') > -1) {
							$('#admin_setup_tree').jstree('select_node', child);
						}
					};
					//---- Enable parents ----
					$('#admin_setup_tree').jstree('select_node', data.node.parent);
					break;
			}
		});
	});
	
	$(document).on("click", "#admin_setup_submit", function() {
		var data = {};
		data.modules = [];
		data.functions = [];
		var selected = $('#admin_setup_tree').jstree('get_selected', true);
		for (var i = 0; i < selected.length; ++i) {
			var type = selected[i].li_attr.class;
			var name = selected[i].li_attr.name;
			if (type == 'module') {
				data.modules.push(name);
			}
			else {
				data.functions.push(name);
			}
		}
		$.ajax({
			async : true,
			cache : false,
			crossDomain : true,
			type : "POST",
			data : data,
			url : "<?php echo MainHelper::site_url("admin/setup"); ?>"
		}).done(function() { window.location.href = "<?php echo MainHelper::site_url("admin/setup"); ?>";
		}).fail(function(data) { alert("ERROR : " + data); });
	});
</script>
