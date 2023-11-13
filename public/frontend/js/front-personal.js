$('#personne_morale').click(function(){
    $('#form_usager_personne_physique').hide();
    $('#form_usager_personne_morale').show();
});

 $('#personne_physique').click(function(){
    $('#form_usager_personne_morale').hide();
    $('#form_usager_personne_physique').show();
   
 });

 function soumettre(form){
   $('#modal-confirm').hide();
   $('.modal-backdrop').hide();
      $('#'+form).validate();
      $('#'+form).submit();    
 }