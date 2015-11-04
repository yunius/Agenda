//fonction pour l'animation des dropdown
$('.dropdown').on('show.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });
              
$('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});
//fonction toggle pour barre de filtre

$(function() {
    // run the currently selected effect
    function runEffect() {
      // get effect type from
      var selectedEffect = $( "blind" ).val();
 
      // most effect types need no options passed by default
      var options = {};
      // some effects have required parameters
      if ( selectedEffect === "scale" ) {
        options = { percent: 0 };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: 200, height: 60 } };
      }
 
      // run the effect
      $( "#mesfiltres" ).toggle( selectedEffect, options, 500 );
    };
 
    // set effect from select menu value
    $( "#buttonfiltre" ).click(function() {
      runEffect();
    });
  });


//fonction pour les Tooltips

//$(function() {
//    
//    $( document ).tooltip({
//      position: {
//        my: "center bottom-20",
//        at: "center top",
//        using: function( position, feedback ) {
//          $( this ).css( position );
//          $( "<div>" )
//            .addClass( "arrow" )
//            .addClass( feedback.vertical )
//            .addClass( feedback.horizontal )
//            .appendTo( this );
//        }
//      }
//    });
//  });

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

//**********************************************************************************************///
//mise en place des datePicker

$(function() {
    $( "#filtre_debutPeriode" ).datepicker();
  });


//********************************************************************************************////

//fonction pour activer l'autocompletion de certain select
$(function() {
//  $('#testform').submit(function(e){
//    e.preventDefault();
//  });
  
  $('#collective_typeActivite').selectize({create: true});
  $('#tags').selectize({    
    delimiter: ',',
    persist: true,
    create: function(input) {
      return {
        value: input,
        text: input
      };
    }
  });
});

$(function() {
//  $('#testform').submit(function(e){
//    e.preventDefault();
//  });
  
  $('#collective_objectif').selectize({create: true});
  $('#tags').selectize({    
    delimiter: ',',
    persist: true,
    create: function(input) {
      return {
        value: input,
        text: input
      };
    }
  });
});


//********************************************************************************************////

//ajax pour les select dynamiques
$(document).ready(function()
{
	$(".selectActivite").change(function()
	{
		var idA=$(this).val();
		var dataString = 'idA='+ idA;
	
		$.ajax
		({
			type: "POST",
			url: "../../../app/routes.php/getCotation",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".selectCotation").html(html);
			} 
		});
	});
	
});




//********************************************************************************************////


