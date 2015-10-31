//fonction pour l'animation des dropdown
$('.dropdown').on('show.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });
              
$('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
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
      }
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
      }
    }
  });
});


//********************************************************************************************////


$(document).ready(function()
{
	$(".selectActivite").change(function()
	{
		var idA=$(this).val();
		var dataString = 'idA='+ idA;
	
		$.ajax
		({
			type: "POST",
			url: "/getCotation.php",
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


