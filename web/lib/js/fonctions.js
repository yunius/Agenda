$('.dropdown').on('show.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });
              
$('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});


//********************************************************************************************////

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