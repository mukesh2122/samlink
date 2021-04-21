/**
*	@name							Accordion
*	@descripton						Accordion for Achievement page
*
*	@author							Daniel Jakobsen
*/

$('.achievement_body').hide();
             
$('.achievement_heading').click(function(){
    $(this).next('.achievement_body').toggle('slow','swing'); 

     var src = $(this).children('img').attr('src');

     if(src.indexOf('open') >= 0)
           $(this).children('img').attr('src',src.replace('open','closed'));
     else
           $(this).children('img').attr('src',src.replace('closed','open'));                         
 });