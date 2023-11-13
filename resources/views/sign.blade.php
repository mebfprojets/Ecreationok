<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <title>Signature</title>

    <style>
        .kbw-signature{ width: 80%; height: 400px;}
        /* #sign canvas{
            width: 100% !important;
            height: auto;
        }  */
    </style>

</head>
<body>
    <form action="" method="post">
    @csrf
    <div id="sign">
        <br>
        <textarea name="signed" id="signature" style="display:none"></textarea>
        <button id="clear">Clear Signature</button>
        <button id="clear">Save</button>
    </div>

    </form>

    <script>
       var sign= $('#sign').signature({ syncField: '#signature', syncFormat:'PNG'});
    $('#clear').click(function(e){
        e.preventDefault();
        sign.signature('clear');
        $('#signature').val('');
    });
    </script>

</body>
</html>