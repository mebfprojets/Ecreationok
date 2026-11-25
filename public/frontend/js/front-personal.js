$('#personne_morale').click(function(){
    $('#form_usager_personne_physique').hide();
    $('#form_usager_personne_morale').show();
});

 $('#personne_physique').click(function(){
    $('#form_usager_personne_morale').hide();
    $('#form_usager_personne_physique').show();
   
 });

/*
 * N° de pièce d'identité du promoteur (formulaires usager) : NIP de la CNIB = 17 chiffres,
 * passeport = 8 lettres ou chiffres. Mêmes règles côté serveur (UsagerController::FORMATS_PIECE_IDENTITE).
 */
var FORMATS_PIECE_IDENTITE = {
    cnib: {
        motif: /^[0-9]{17}$/, longueur: 17, clavier: 'numeric', exemple: 'NIP : 17 chiffres',
        message: 'Le NIP de la CNIB doit comporter exactement 17 chiffres, sans lettre.'
    },
    passeport: {
        motif: /^[A-Z0-9]{8}$/, longueur: 8, clavier: 'text', exemple: 'N° du passeport : 8 caractères',
        message: 'Le numéro de passeport doit comporter exactement 8 caractères : lettres et chiffres uniquement.'
    }
};

function champsPieceIdentite(element) {
    var $form = $(element).closest('form');
    return { type: $form.find('[name="type_piece_identite"]'), numero: $form.find('[name="numero_piece"]') };
}

// Message d'erreur du N° de pièce, ou '' s'il est correct (vide : laissé à la règle « obligatoire »)
function erreurPieceIdentite(element) {
    var champs = champsPieceIdentite(element);
    var format = FORMATS_PIECE_IDENTITE[champs.type.val()];
    var numero = String(champs.numero.val() || '').replace(/\s+/g, '').toUpperCase();
    if (numero === '') { return ''; }
    if (!format) { return 'Choisissez d’abord le type de pièce d’identité (CNIB ou passeport).'; }
    return format.motif.test(numero) ? '' : format.message;
}

function actualiserPieceIdentite(element) {
    var champs = champsPieceIdentite(element);
    if (!champs.numero.length) { return; }
    var format = FORMATS_PIECE_IDENTITE[champs.type.val()];
    if (format) {
        champs.numero.attr({ maxlength: format.longueur, inputmode: format.clavier, placeholder: format.exemple });
    } else {
        champs.numero.removeAttr('maxlength').attr({ inputmode: 'text', placeholder: 'Choisissez d’abord le type de pièce' });
    }
    // Validation native du navigateur (fenêtres envoyées en AJAX)
    champs.numero[0].setCustomValidity(erreurPieceIdentite(champs.numero[0]));
}

$(document).on('change', '[name="type_piece_identite"]', function () {
    actualiserPieceIdentite(this);
    // Revalide le numéro déjà saisi quand le formulaire est suivi par jQuery Validate
    var $numero = champsPieceIdentite(this).numero;
    if ($numero.val() && $.data($numero[0].form, 'validator')) { $numero.valid(); }
});
$(document).on('input', '[name="numero_piece"]', function () {
    var propre = this.value.replace(/\s+/g, '').toUpperCase();
    if (propre !== this.value) { this.value = propre; }
    actualiserPieceIdentite(this);
});
$(document).on('reset', 'form', function () {
    var form = this;
    setTimeout(function () { $(form).find('[name="numero_piece"]').each(function () { actualiserPieceIdentite(this); }); }, 0);
});
$(function () {
    $('[name="numero_piece"]').each(function () { actualiserPieceIdentite(this); });
});

// Formulaire principal (jQuery Validate, qui ignore la validation native) : la classe « numeroPieceIdentite » applique la règle
if ($.validator) {
    $.validator.addMethod('numeroPieceIdentite', function (valeur, element) {
        return this.optional(element) || erreurPieceIdentite(element) === '';
    }, function (parametres, element) {
        return erreurPieceIdentite(element);
    });
}

 function soumettre(form){
   $('#modal-confirm').hide();
   $('.modal-backdrop').hide();
      $('#'+form).validate();
      $('#'+form).submit();    
 }