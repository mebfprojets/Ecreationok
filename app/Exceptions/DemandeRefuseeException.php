<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Création de demande refusée pour une raison compréhensible par l'usager
 * (nom déjà utilisé, tarif ou CEFORE introuvable...). Le message est affiché tel quel.
 */
class DemandeRefuseeException extends RuntimeException
{
}
