<script>


$(document).ready(function() {
// Tooltip only Text
$('.masterTooltip').hover(function(){
 //        Hover over code
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<p class="tooltip"></p>')
        .text(title)
        .appendTo('body')
        .fadeIn('slow');
}, function() {
  //       Hover out code
        $(this).attr('title', $(this).data('tipText'));
        $('.tooltip').remove();
}).mousemove(function(e) {
        var mousex = e.pageX + 20; //Get X coordinates
        var mousey = e.pageY + 10; //Get Y coordinates
        $('.tooltip')
        .css({ top: mousey, left: mousex })
	
});



	$("#sell_inactive").hide();
	$("#sell_active").show();
        
});

$(document).ready( function() {
	
	$('.sale_pay').hide();
	$('.pay_type').hide();
	$('.auction_op').hide();
	$('.price_cur').hide();
	$('.mycurrency').hide();
	 $('#showtype').hide();	
	 
  $('#noticetype').bind('change', function (e) { 
     if( $('#noticetype').val() == 'trade') {
		 
    $('.sale_pay').hide();
	$('.auction_op').hide();
	$('.price_cur').hide();
	$('.pay_type').hide();
    $('#showtype').hide();
	$('.mycurrency').hide();
	 }
	if( $('#noticetype').val() == 'buy') {
      $('.pay_type').show();
	  $('#showtype').show();
	    $('.mycurrency').hide();
		  $('.auction_op').hide();
		  $('.sale_pay').hide();
    }
	if( $('#noticetype').val() == 'sell') {
      $('.sale_pay').show();
    }
	
  });
  
   $('#saletype').bind('change', function (e) {
	    
  if( $('#saletype').val() == 'buynow') {
       $('#showtype').show();
	  $('.pay_type').show();
	  $('.auction_op').hide();
    }
	if( $('#saletype').val() == 'auction') {
      $('.auction_op').show();
	  $('.price_cur').hide();
	    $('.mycurrency').hide();
		$('.pay_type').hide();
		  $('#showtype').hide();
    }
   });
   
     $('#paymenttype').bind('change', function (e) {
	    
  if( $('#paymenttype').val() == 'credits') {
      $('.price_cur').show();
	  $('.auction_op').hide();
	   $('.mycurrency').hide();
    }
	if( $('#paymenttype').val() == 'none') {
      $('.price_cur').show();
	  $('.mycurrency').show();
    }
   });
});


// category animation

$(document).ready(function(){
	
 $( ".show_dropdown" ).hide();
  $(".add_cat").click(function(){
  $( ".show_hide" ).hide();
    $( ".show_dropdown" ).slideDown( "slow" );
  
});
//catia
$( ".show_dropdown_img" ).hide();
$(".add_album").click(function(){
  $( ".show_hide" ).hide();
    $( ".show_dropdown_img" ).slideDown( "slow" );
  
});
//catia end

 $(document).on('click', '.close', function(){
        $(this).parent().slideUp("slow");
		$( ".show_hide" ).hide();
    });
	
//catia
$(document).on('click', '.close_album', function(){
        $(this).parent().slideUp("slow");
		$( ".show_hide" ).hide();
    });
//catia end
 }); 
  
  
	
//*****************catia********************
function insertalbum()
{
	document.getElementById('button_images').value = '1';
	document.getElementById("cnForm").submit();
}
function createSliderUploader(ids, text, url, size) {
		
		var sizeAction = (url.indexOf('?') > -1) ? '&' : '?';
		sizeAction += 'DestWidth='+size.x+'&DestHeight='+size.y;
	    
	    return new qq.FileUploader({
	        debug: false,
	        sizeLimit: 2097152,
	        textUpload: text,
	        element: document.getElementById(ids),
	        listElement: document.getElementById('img_load'), // ???
	        action: site_url + url,
	        multiple: false,
	        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
	        acceptTypes: 'image/*',
	        onSubmit: function(id, fileName){
	        	/*
	            	$('.personal_profile_short').addClass('dn');
	            	$("#img_load").removeClass('dn').html('');
	            */
	        },
	        onComplete: function(id, fileName, responseJSON){
	            if(responseJSON.error) {
	                return false;
	            }

	            /*
	            	$('.personal_profile_short').removeClass('dn');
	            	$("#img_load").addClass('dn');
	            */

	            if(true){
	                var aspectRatio = size.x/size.y;
	                var cropLength = Array;

	                $("body").addClass('index_events_create');
	                $("body").append('<div id="openWindow_'+ids+'"></div>');
	                
	                $('#openWindow_'+ids).html('<img id="'+ids+'_load" />'); // ??
	                
	                $('#'+ids+'_load').attr('src', responseJSON.img800x600).load(function() {
	                    $('#openWindow_'+ids).dialog({
	                        title: 'Select part of image',
	                        resizable: false,
	                        modal: true,
	                        width: 825,
	                        autoOpen: true,
	                        close: function() {
	                            $(this).dialog('destroy');
	                            $(this).remove();
	                        },
	                        buttons: {
	                            Crop: function() {
	                                $.ajax({
	                                    url: site_url + url + sizeAction,
	                                    type: 'POST',
	                                    dataType: 'json',
	                                    data: cropLength,
	                                }).done(function( responseJSON ) {
	                                    if(responseJSON.img) {
	                                    	var imageName = responseJSON.img.substring(responseJSON.img.lastIndexOf('/')+1);
	                                    	$('select[name=Image]').append($('<option class="centered" value="'+imageName+'" selected="selected">'+imageName+'</option>'));
	                                    }
	                                });
	                                
	                                $(this).dialog('destroy');
	                                $(this).remove();
	                            },
	                        }
	                    }).ready(function(){
	                        $('#'+ids+'_load').Jcrop({
	                            aspectRatio: aspectRatio,
	                            bgColor: 'black',
	                            bgOpacity: .6,
	                            minSize: [size.x, size.y],
	                            //maxSize: [size.x, size.y],
	                            setSelect:   [ 0, 0, size.x, size.y ],
	                            onSelect: function updateCoords(c) {
	                                cropLength = c;
	                            },
	                        });
	                    });
	                });
	            }
	        }
	    });
	}
	
	//***************************catia buyselltrade ***************************
	$('.imagebuyselltrade').fancybox({
		'closeClick': false,
		'openEffect': 'elastic',
		'closeEffect': 'elastic',
		'openSpeed': 600,
		'closeSpeed': 200,
		'loop': true,
		'arrows': false,
		'scrolling': 'no',
		'keys': null,
		'type': 'ajax',
		'helpers': {
			'title': null,
			'overlay': {
				'showEarly': true,
				'closeClick': false,
				'css': {
					'background': 'rgba(0, 0, 0, 0.58)'
				}
			}
		}
	});
	//***************************end catia buyselltrade ***************************
	

</script>

	