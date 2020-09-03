        
        // My js Editing

$( function () {

    'use strict';

    // Dashboard  - show / hidden lastest 

    $('.toggle-info').click(function(){

      $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

      if ($(this).hasClass('selected')){

        $(this).html('<i class="fa fa-plus fa-lg"></i>');

      }else{

        $(this).html('<i class="fa fa-minus fa-lg"></i>');

      }

    });

    // Search 
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }); 

    //Hide Placeholde 'Username' && 'Password' On Form Focus

    $('[placeholder]').focus(function () {

      $(this).attr('data-text',$(this).attr('placeholder'));

      $(this).attr('placeholder','');

    }).blur(function () {

      $(this).attr('placeholder' , $(this).attr('data-text'));

    });

    // Add Asterisk On Required Field

    // $('input').each(function(){

    //   if ($(this).attr('required') === 'required'){//attripute

    //     $(this).after('<span class="asterisk"> * </span>');

    //   }

    // });

    // Convert Password Faild To Text Field On Hover

    var passFiled = $('.password');

    $('.show-pass').hover(function () {

      passFiled.attr('type', 'text');

    } , function () {

        passFiled.attr('type','password');

    });

     // Confirmation Message To Delete 
     $('.confirm').click(function (){

        return confirm('Are You Sure ?');

     });

   // Category View Option

   $('.cat h3').click(function (){
      $(this).next('.full-view').fadeToggle(200);
   }) 

   $('.option span').click(function(){

      $(this).addClass('active').siblings('span').removeClass('active');

      if ( $(this).data('view') === 'full' ){

        $('.cat .full-view').fadeIn(200);

      }else{

        $('.cat .full-view').fadeOut(200);

      }

   });

   // Show Delete Button On Child Cats

   $('.child-link').hover(function (){

      $(this).find('.show-delete').fadeIn(400);

   }, function (){

      $(this).find('.show-delete').fadeOut(400);

   });


});
