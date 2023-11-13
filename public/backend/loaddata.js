
$(document).ready(function () {
    $("#saveData").on('click', function(){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                var url = "{{ route('piecejointe.laod') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    enctype: 'multipart/form-data',
                    data: $('#fileUploadForm').serialize(),
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (response) {
        
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
        var url = "{{ route('piecejointe.laod') }}";
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