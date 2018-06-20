<?php

namespace App\Services\CSVImporter\Exceptions;

/**
 * Class MissingParticipantEmailException
 * @package App\Services\CSVImporter\Exceptions
 */
class MissingParticipantEmailException extends CSVImporterException
{

    const CODE = 'missing_participant_email';
}