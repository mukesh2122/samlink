<script>

$(document).ready(function(){
	
 $( "#blockcomments" ).hide();
 $( "#linkhidedescription" ).hide();
  $("#linkshowdescription").click(function(){
  $( ".show_hide" ).hide();
    $( "#blockcomments" ).slideDown( "slow" );
	$("#linkshowdescription" ).hide();
	$( "#linkhidedescription" ).show();
  
});

 $(document).on('click', '.close', function(){
        $(this).parent().slideUp("slow");
		$( ".show_hide" ).hide();
		$( "#blockcomments" ).slideUp("slow");
		$( "#linkhidedescription" ).hide();
		$("#linkshowdescription" ).show();
    });



 }); 


function verify(object) {
		show_alert = '';
		//if (document.getElementById('owner').value=='') {
//			show_alert = 'You have to be Login to create a notice ';
//		}
//		if (document.getElementById('game').value=='') {
//			if (show_alert!='') {
//				show_alert+= ' and ou must choose a Game!';
//			} else {
//				show_alert = 'You must choose a Game!';
//			}
//		} else {
//			if (show_alert!='') {
//				show_alert += '!';
//			}
//		}
		var link_redirect = document.getElementById('link_create').value;
		if (show_alert!='') {
			alert(show_alert);
			
		} else {
			document.getElementById("gamedescriptionform").submit(); 
		}
	}
	function submitgamedescription() {
		document.getElementById("gamedescriptionform").submit();
	}
	function submitgamedescriptionprevious() {
		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value + '&details=next&description=next';
		document.getElementById("gamedescriptionform").action = link_action;
		document.getElementById("gamedescriptionform").submit();
	}
	function submitfinalizeform() {
		document.getElementById("finalizeform").submit();
	}
	function submitfinalizeformprevious() {
		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value + '&details=next&description=next';
		document.getElementById("finalizeform").action = link_action;
		document.getElementById("finalizeform").submit();
	}
	function submitdetails() {
		document.getElementById("gamedetailsform").submit();
	}
	function submitdetailsprevious() {
		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
		
		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value;
		document.getElementById("gamedetailsform").action = link_action;
		document.getElementById("gamedetailsform").submit();
	}
	function submittype(object) {
		var groupid = object.id;
		var link_action =  document.getElementById("link").value;
		document.getElementById("ownerid").value = groupid;
		document.getElementById("typeuserform").action = link_action;
		document.getElementById("typeuserform").submit();
	}
	function submitgame(object) {
		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
		var gameid = object.id;
		var link_action =  document.getElementById("link").value + '?step=2&type=' + document.getElementById("type").value + '&game=' + gameid;
		document.getElementById("search_form").action = link_action;
		document.getElementById("search_form").submit();
	}
	function submitgamenext(object) {
		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
		var gameid = object.id;
		var link_action =  document.getElementById("link").value + '?step=3&type=' + document.getElementById("type").value + '&game=' + gameid;
		document.getElementById("search_form").action = link_action;
		document.getElementById("search_form").submit();
	}
	
</script>

	