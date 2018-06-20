<?php

namespace App\Services\CSVImporter\Exceptions;

/**
 * Class MissingEmergencyContactPhoneException
 * @package App\Services\CSVImporter\Exceptions
 */
class MissingEmergencyContactPhoneException extends CSVImporterException
{

    const CODE = 'missing_emergency_contact_phone';
}