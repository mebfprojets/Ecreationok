
// Affiche dans la fenêtre de chargement un message d'erreur lisible (voir public/js/erreurs-ajax.js)
function afficherErreurChargement(xhr) {
    var message = typeof messageErreurAjax === 'function' ? messageErreurAjax(xhr) : 'Une erreur est survenue. Réessayez.';
    $('.upload_image').html($('<label class="text-danger" style="white-space: pre-line"></label>').text(message));
}

$(document).ready(function () {
    $(document).on('submit', '#fileUploadForm', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                var form = $('#fileUploadForm')[0];
                console.log(form);
                var formData = new FormData(form);
                formData.append('piece_jointe_1', document.querySelector('#piece_jointe_1').files[0]);
                //form_data.append('file', document.getElementById('piece_jointe_1').files[0]);
                console.log(formData);
                $.ajax({
                    url: '/load/piecejointe',
                    type: "POST",
                   // enctype: 'multipart/form-data',
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('.upload_image').html('<label class="text-success">Chargement en cours ....</label>');
                    },
                    success: function (response) {
                        //$('.upload_image').html('<label class="text-success">Fichier chargé avec succes. Fermer la fenetre</label>');
                        //$(this).modal('hide');                        
                        console.log(response.type_doc);
                        if(response.type_doc=='declaration'|| response.type_doc=='casier_judiciaire'){
                            $('.input_declaration').val('declaration/casier judiciaire')
                           // $('.declaration').hide()
                            $('.declaration_group_edit').show()
                            $('.declaration_group_add').hide()
                        }
                        else if(response.type_doc=='certificat_de_residence'){
                            $('.input_certificat_de_residence').val('Certificat de residence')
                            $('#certificat_de_residence').hide()
                            $('.certificat_de_residence_group_edit').show()
                            $('.certificat_de_residence_group_add').hide()
                        }
                        else if(response.type_doc=='formulaire_dem_cpc'){
                            
                            $('.formulaire_dem_cpc_input').val('Demande formulaire cpc')
                           // $('#formulaire_dem_cpc').hide()
                            $('.formulaire_dem_cpc_group_edit').show()
                            $('.formulaire_dem_cpc_group_add').hide()
                        }
                        else if(response.type_doc=='cnib'||response.type_doc=='passport'){
                            $('.piece_didentite_input').val('Document didentite')
                           // $('.piece_didentite').hide()
                            $('.piece_didentite_group_edit').show()
                            $('.piece_didentite_group_add').hide()
                        }
                        else if(response.type_doc=='photo_didentite'){
                            $('.photo_didentite_input').val('Photo identite')
                         //   $('#photo_didentite').hide()
                            $('.photo_didentite_group_edit').show()
                            $('.photo_didentite_group_add').hide()
                        }
                        else if(response.type_doc=='titre_de_propriete'){
                            $('.titre_de_propriete_input').val('Titre de propriete')
                           // $('.titre_de_propriete').hide()
                            $('.titre_de_propriete_group_edit').show()
                            $('.titre_de_propriete_group_add').hide()
                        }
                        else if(response.type_doc=='statut'){
                            $('.statut_input').val('Statut')
                           // $('.statut').hide()
                            $('.edit_statut_group_hide').show()
                            $('.add_statut_group').hide()
                        }
                        
                        else if(response.type_doc=='formulaire_rccm'){
                            $('.formulaire_rccm_input').val('formulaire_rccm')
                           // $('.formulaire_rccm').hide()
                            $('.formulaire_rccm_group_add').hide()
                            $('.formulaire_rccm_group_edit').show()
                        }
                        else if(response.type_doc=='acte_de_depot'){
                            $('.acte_de_depot_input').val('acte_de_depot')
                            $('.acte_de_depot_group_add').hide()
                            $('.acte_de_depot_group_edit').show()
                        }
                        else if(response.type_doc=='formulaire_cpc_es'){
                            $('.formulaire_cpc_es_input').val('formulaire_cpc_es')
                            $('.formulaire_cpc_es_group_add').hide()
                            $('.formulaire_cpc_es_group_edit').show()
                        }
                        $('#'+response.type_doc).val(response.type_doc);  
                        $('.upload_image').html('<label class="text-success">Fichier chargé avec succes. Fermer la fenetre</label>');
                         
                       
                    },
                    error: function (xhr) {
                        afficherErreurChargement(xhr);
                    }
                });
    });
    $(document).on('submit', '#fileUploadForm_u', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                var form = $('#fileUploadForm_u')[0];
                console.log(form);
                var formData = new FormData(form);
                formData.append('piece_jointe_u', document.querySelector('#piece_jointe_u').files[0]);
                //form_data.append('file', document.getElementById('piece_jointe_1').files[0]);
                console.log(formData);
                $.ajax({
                    url: '/update/piecejointe',
                    type: "POST",
                   // enctype: 'multipart/form-data',
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('.upload_image').html('<label class="text-success">Chargement en cours ....</label>');
                    },
                    success: function (response) {
                        $('#fileUploadForm_u')[0].reset();
                        $('.upload_image').html('<label class="text-success">Fichier chargé avec succes. Fermer la fenetre</label>');
                        //$(this).modal('hide');
                        
                        //$("#updatepiecejointe").hide();
                        // $('.modal-backdrop').remove();
                        // $('.modal-backdrop').add();
                        //$('.upload_image').html('<label class="text-success"></label>');
                        //$('#addpiecejointe').modal('hide');
                        console.log(response.type_doc);
                        // if(response.type_doc=='declaration'|| response.type_doc=='casier_judiciaire'){
                        //     $('.input_declaration').val('declaration/casier judiciaire')
                        //     $('.declaration').hide()
                        //     $('.declaration_edit').show()
                        //     $('.declaration_view').show()
                        // }
                        // else if(response.type_doc=='certificat_de_residence'){
                        //     $('#input_certificat_de_residence').val('Certificat de residence')
                        //     $('#certificat_de_residence').hide()
                        //     $('#certificat_de_residence_edit').show()
                        //     $('#certificat_de_residence_view').show()
                        // }
                        // else if(response.type_doc=='formulaire_dem_cpc'){
                        //     $('#formulaire_dem_cpc_input').val('Demande formulaire cpc')
                        //     $('#formulaire_dem_cpc').hide()
                        //     $('#formulaire_dem_cpc_edit').show()
                        //     $('#formulaire_dem_cpc_view').show()
                        // }
                        // else if(response.type_doc=='cnib'||response.type_doc=='passport'){
                        //     $('.piece_didentite_input').val('Document didentite')
                        //     $('.piece_didentite').hide()
                        //     $('.piece_didentite_edit').show()
                        //     $('.piece_didentite_view').show()
                        // }
                        // else if(response.type_doc=='photo_didentite'){
                        //     $('#photo_didentite_input').val('Photo identite')
                        //     $('#photo_didentite').hide()
                        //     $('#photo_didentite_edit').show()
                        //     $('#photo_didentite_view').show()
                        // }
                        // else if(response.type_doc=='titre_de_propriete'){
                        //     $('.titre_de_propriete_input').val('Titre de propriete')
                        //     $('.titre_de_propriete').hide()
                        //     $('.titre_de_propriete_edit').show()
                        //     $('.titre_de_propriete_view').show()
                        // }
                        // else if(response.type_doc=='statut'){
                        //     $('.statut_input').val('Statut')
                        //     $('.statut').hide()
                        //     $('.statut_edit').show()
                        //     $('.statut_view').show()
                        // }
                        // else if(response.type_doc=='formulaire_rccm'){
                        //     $('.formulaire_rccm_input').val('formulaire_rccm')
                        //     $('.formulaire_rccm').hide()
                        //     $('.formulaire_rccm_edit').show()
                        //     $('.formulaire_rccm_view').show()
                        // }
                        // else if(response.type_doc=='acte_de_depot'){
                        //     $('.acte_de_depot_input').val('acte_de_depot')
                        //     $('.acte_de_depot').hide()
                        //     $('.acte_de_depot_edit').show()
                        //     $('.acte_de_depot_view').show()
                        // }
                        // $('#'+response.type_doc).val(response.type_doc);
                        // $('.upload_image').html(' ');

                    },
                    error: function (xhr) {
                        afficherErreurChargement(xhr);
                    }
                });
    });
    $(document).on('submit', '#formusager', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                var form = $('#formusager')[0];
                console.log(form);
                var formData = new FormData(form);
                console.log(formData);
                $.ajax({
                    url: '/usager-storing',
                    type: "POST",
                   // enctype: 'multipart/form-data',
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('.upload_image').html('<label class="text-success">Chargement en cours ....</label>');
                    },
                    success: function (data) {
                        $('.upload_image').html($('<label class="text-success"></label>').text(
                            (data && data.message ? data.message : 'Promoteur enregistré.') + ' Vous pouvez fermer la fenêtre.'));
                        // Le nouveau promoteur devient sélectionnable dans les listes de recherche (Select2)
                        if (data && data.usager) {
                            $('select.recherche-usager').each(function () {
                                if (!$(this).find('option[value="' + data.usager.id + '"]').length) {
                                    $(this).append(new Option(data.usager.text, data.usager.id, false, false));
                                }
                            });
                        }
                        $('#formusager')[0].reset();
                    },
                    error: function (xhr) {
                        afficherErreurChargement(xhr);
                    }
                });
    });




});