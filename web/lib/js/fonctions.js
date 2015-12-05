//fonction pour l'animation des dropdown
$('.dropdown').on('show.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });
              
$('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});


//fonctions toggles pour barre de filtre
$(function() {
    // run the currently selected effect
    function runEffect() {
      // run the effect
      $( "#mesfiltres" ).toggle( 'blind', 'linear', 500 );
      $( "#mesfiltres").removeClass(".filtreHidden")
    };
 
    // set effect from select menu value
    $( "#buttonfiltre" ).click(function() {
      runEffect();
    });
});

//$(document).ready(function()
//{
//	$("#filtre_choixFiltre").change(function() { 
//            var value= $("#filtre_choixFiltre input[type='radio']:checked").val();
//            
//            if(value == 0) {
//                $( "#filtre_finPeriode" ).hide();
//            }
//            if(value == 1) {
//                $( "#filtre_finPeriode" ).removeClass('.filtreDateFinHidden')
//                $( "#filtre_finPeriode" ).show();
//            }
//            
//            
//	});
//	
//});


//fonction pour les Tooltips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});



//fonction pour les spinner

$(function() {
    $( "#collective_collDenivele" ).spinner({
      step: 100,
      numberFormat: "n"
    });
    
    $( "#collective_nbMax" ).spinner({
      step: 1,
      numberFormat: "n"
    });
  });
  
  




//**********************************************************************************************///
//mise en place des datePicker

(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../jquery.ui.datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {
	datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
			'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
		monthNamesShort: ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin',
			'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
		dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
		dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	datepicker.setDefaults(datepicker.regional['fr']);
	return datepicker.regional['fr'];

}));

$(function() {
    
    //filtre accueil
    $( ".monDebutPeriodeEncadrant" ).datepicker({ 
        
        onClose : function(selectedDate) {
            $("#filtre_finPeriode").datepicker("option", "minDate", selectedDate);
        }
    });
    
    $( ".monDebutPeriode" ).datepicker({ 
        minDate: '0', 
        onClose : function(selectedDate) {
            $("#filtre_finPeriode").datepicker("option", "minDate", selectedDate);
        }
    });
    
    $( "#filtre_finPeriode" ).datepicker();
    
    //editeur de collective
    $( "#collective_collDateDebut" ).datepicker({ 
        minDate: '0', 
        onClose : function(selectedDate) {
            $("#collective_collDateFin").datepicker("option", "minDate", selectedDate);
        }
    });
    
    $( "#collective_collDateFin" ).datepicker();
    
    
    $('#collective_heureRDV').timepicker({
	timeOnlyTitle: 'Choisir l\'horaire',
	timeText: 'Horaire',
	hourText: 'heures',
	minuteText: 'minutes',
	currentText: 'maintenant',
	closeText: 'Valider',
        showButtonPanel: 'false'
        }
    );
  });


//********************************************************************************************////

//fonction pour activer l'autocompletion et l'add de certain select
$(function() {
//  $('#testform').submit(function(e){
//    e.preventDefault();
//  });
  
  $('#collective_typeActivite').selectize({create: false});
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



  
  $('#collective_secteur').selectize({create: true});
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

  
  $('#collective_MaterielCollective').selectize({create: false});
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
  
  $('#filtre_adherent').selectize({create: false});
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
//                var path = $("#abc").attr("data-path");
		$.ajax
		({
			type: "POST",
			url: '/cotation/',
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".selectCotation").html(html);
			} 
		});
                $.ajax
                ({
                        type: "POST",
			url: '/materiel/',
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".listTypeMateriel").html(html);
			} 
                });
	});
        $('#MatTempDeleteForm').on('submit', function(e) {
            e.preventDefault();
            var materielAsuppr = $('#materielAsuppr').val();
            $.ajax
                ({
                        type: "POST",
			url: '/materiel/',
			data: materielAsuppr,
			cache: false,
			success: function(html)
			{
				$(".listTypeMateriel").html(html);
			} 
                });
        });
	
});




//********************************************************************************************////

//tabs function

$("#tabs").tabs( { show: { effect: "slide", direction: "left", duration: 500 }});
