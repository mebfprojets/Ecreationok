
$(document).ready(function () {
    $(document).on('submit', '#fileUploadForm', function(e){
       // alert('ok');
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
                var url = '{{ route("piecejointe.laod") }}';
                $.ajax({
                    url: 'http://20.121.129.137/Ecreation_Barro1S/public/load/piecejointe',
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
                        $('.upload_image').html('<label class="text-success">Fichier chargé avec succes. Fermer la fenetre</label>');
                        //$(this).modal('hide');
                        $("#addpiecejointe").modal("hide");
                        //$('#addpiecejointe').modal('hide');
                        console.log(response.type_doc);
                        if(response.type_doc=='declaration'|| response.type_doc=='casier_judiciaire'){
                            $('.input_declaration').val('declaration/casier judiciaire')
                           // $('.declaration').hide()
                            $('.declaration_group_edit').show()
                            $('.declaration_group_add').hide()
                        }
                        else if(response.type_doc=='certificat_de_residence'){
                            $('#input_certificat_de_residence').val('Certificat de residence')
                            $('#certificat_de_residence').hide()
                            $('#certificat_de_residence_edit').show()
                            $('#certificat_de_residence_view').show()
                        }
                        else if(response.type_doc=='formulaire_dem_cpc'){
                            $('#formulaire_dem_cpc_input').val('Demande formulaire cpc')
                           // $('#formulaire_dem_cpc').hide()
                            $('#formulaire_dem_cpc_group_edit').hide()
                            $('#formulaire_dem_cpc_group_add').show()
                        }
                        else if(response.type_doc=='cnib'||response.type_doc=='passport'){
                            $('.piece_didentite_input').val('Document didentite')
                           // $('.piece_didentite').hide()
                            $('.piece_didentite_group_edit').show()
                            $('.piece_didentite_group_add').hide()
                        }
                        else if(response.type_doc=='photo_didentite'){
                            $('#photo_didentite_input').val('Photo identite')
                         //   $('#photo_didentite').hide()
                            $('#photo_didentite_group_edit').show()
                            $('#photo_didentite_group_add').hide()
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
                           // $('.acte_de_depot').hide()
                            $('.acte_de_depot_edit').show()
                            $('.acte_de_depot_add').hide()
                        }
                        $('#'+response.type_doc).val(response.type_doc);
                        $('.upload_image').html(' ');

                    },
                    error: function (e) {
        
        
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
                var url = '{{ route("piecejointe.update") }}';
                $.ajax({
                    url: 'http://localhost:4000/update/piecejointe',
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
                        $('.upload_image').html('<label class="text-success">Fichier chargé avec succes. Fermer la fenetre</label>');
                        //$(this).modal('hide');
                        $("#updatepiecejointe").modal("hide");
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
                    error: function (e) {
        
        
                    }
                });
    });
    $("#btnSubmit").click(function (event) {
        alert('on commence');
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        //stop submit the form, we will post it manually.
        event.preventDefault();

        // Get form
        var form = $('#fileUploadForm')[0];

		// Create an FormData object 
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);
      
        $.ajax({
            url: url,
            type: "get",
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                $("#result").text(data);
                console.log("SUCCESS : ", data);
                $("#btnSubmit").prop("disabled", false);
            },
            error: function (e) {

                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
        });

    });

});