
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});

//start js for share buttom
//Display popover that contain link of post
$('.change-trigger').popover({
  placement : 'bottom',
  title : 'Change',
  trigger : 'click',
  html : true,
  content : function(){
    var content = '';
    content = $('#html-div').html();
    return content;
  } 

});

//copy link
function myFunction() {
  var copyText = document.getElementById("post_link");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
   $(".popover").each(function () {
        $(this).popover("hide");
    });
}

//hide popover while click on any area in page
$('html').on('click', function(e) {
var eles = document.getElementById('share').getElementsByTagName('buttom');
for (var i=0; i < eles.length; i++)
   eles[i].onclick = function() {
     return false;
   }

  if (typeof $(e.target).data('original-title') == 'undefined' &&
     !$(e.target).parents().is('.popover.in')) {
    $('[data-original-title]').popover('hide');
  }
  
});
//END share buttom


