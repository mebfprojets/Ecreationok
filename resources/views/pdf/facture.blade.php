<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>

    <style type="text/css">
        .enteteGauche{
            float: left;
            width: 50%;
            text-align: center;
        }
        .entetedroite{
            float: left;
            width: 50%;
            text-align: center;
        }
        .entete{
            margin-top:90px;
            text-align: center;
            color:red;
            font-weight: blod;
            margin-bottom: 55px;
        }
        .titre{
            position:relative;
            margin-left:20px;
            width:50%;
            border:solid 2px black;
            padding-right:10px;
            text-align:center;

        }
        .contenu{
            position:relative;
            margin-right:20px;
            width:40%;
            text-align:center;
            padding-left:10px;
            display:inline-block;
        }
        .cefore{
            margin-left:50px;
            border-bottom-style: solid;
            border-bottom-color: #0000ff;
  border-bottom-width: 6px;
        }
        .enr{
            margin-left:70%;
        }
        .table, td{
            border: 1px solid;
            height: 30px;
        }
        .table{
            width: 90%;
            border-collapse: collapse;
        }
        
    </style>
</head>
<body>

        <div class="cefore">
            <img style="margin-left:-6px;" src="{{ asset('frontend/images/CEFORE1.JPG') }}" width=90 height=60 alt="">
            <p style="font-weight: bold; margin-left:90px; font-size: 13px; margin-top:-50px">CENTRE DE FORMALITE DES ENTREPRISES DU BURKINA FASO (CEFORE)</p>
            <div style="">
            <p style="margin-left:90px; font-size: small; margin-top:-14px;">132, Avenue de Lyon -11 BP 379 Ouagadougou 11 Burkina Faso</p>
            <p style="margin-left:90px; font-size: small; margin-top:-14px;">Tel : (00226) 25 39 80 60/61 Fax : (00226) 25 39 80 62</p>
            <p style="margin-left:90px; font-size: small; margin-top:-14px;">Email : info@me.bf Site Web : www.me.bf </p>
            </div>
        </div>
        <div class="enr mebf">
           <strong> <p style="margin-top:0px;">ENR/ CEFORE/ 11- REV1</p></strong>
        </div>
        <div style="margin-left:50px; font-size: 14px;">
        <strong><p>FACTURE N°: {{$demande->numero_demande}} du {{ date("d-m-Y à H:i", strtotime($demande->date_paiement)) }}</p></strong>
        <strong><p>Promoteur : {{$demande->legal_rep_name}} </p></strong>
        <strong><p>Téléphone : {{$usager->Phone_No_}} - {{$usager->Tel_Bureau}}</p></strong>
        <strong><p>Raison Sociale : {{$demande->commercial_name}}</p></strong>
        <strong><p>Contact Entreprise : {{$demande->mobile_1}} - {{$demande->tel_bureau}}</p></strong>
        </div><br>
        <table class="table" style="margin-left:50px;">
                                <tbody> 
                                            <tr>
                                                <td style="background-color: #f0f0f0; height: 40px;"><strong>FORMALITES SOUSCRITES</strong></td>
                                                                                                                   
                                            </tr>                                            
                                            <tr>
                                                <td>RCCM - REGISTRE DU COMMERCE ET DU CRÉDIT MOBILIER</td>                                                                                                                     
                                            </tr> 
                                            <tr>
                                                <td>CNSS - CAISSE NATIONALE DE SÉCURITÉ SOCIALE</td>                                                                                                                     
                                            </tr>  
                                            <tr>
                                                <td>IFU - IDENTIFIANT FISCAL UNIQUE</td>                                                                                                                     
                                            </tr>
                                            @if($demande->avecCPC==1)     
                                            <tr>
                                                <td>CPC - CARTE PROFESSIONNELLE DE COMMERÇANT</td>                                                                                                                     
                                            </tr>            
                                            <tr>
                                                <td>IMPRIME CPC - IMPRIMÉ CARTE PROFESSIONNELLE DE COMMERÇANT</td>                                                                                                                     
                                            </tr> 
                                             @endif
                                             <tr>
                                                <td>SEMINAIRE DE FORMATION EN GESTION D'ENTREPRISES</td>                                                                                                                     
                                            </tr>
                                            @if($demande->company_type=="ES")
                                            <tr>
                                                <td>ANNONCES LEGALES</td>                                                                                                                     
                                            </tr>
                                            @endif               
                                    </tbody>
                          </table><br>
                          <table class="table" style="margin-left:50px;">
                                <tbody> 
                                            <tr>
                                                <td>TOTAL FACTURE : </td>
                                                <td><strong>{{$demande->montant_total}}</strong></td>                                                                          
                                            </tr>                                                              
                                    </tbody>
                          </table><br><br><br>
        <div class="enr mebf">
           <strong> <p style="margin-left:-40%">CEFORE/MEBF</p></strong>
        </div>
        <strong><p style="margin-left:70px;">NB: Le montant est exprimé en FCFA</p></strong>
        <br><br>
        <img style="margin-left:550px" src="data:image/png;base64,{{ $qrCode }}" alt="Code QR">
       
        <p style="margin-left:70px; border-bottom-style: solid;
            border-bottom-color: #0000ff;
  border-bottom-width: 6px;"></p>
  <p style="margin-left:70px; margin-top:-10px;">Imprimé le {{ date("d-m-Y à H:i") }}</p>
        
</body>
</html>

