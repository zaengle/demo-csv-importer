<?php

namespace App\Services\CSVImporter\Exceptions;

/**
 * Class MissingEmergencyContactNameException
 * @package App\Services\CSVImporter\Exceptions
 */
class MissingEmergencyContactNameException extends CSVImporterException
{

    const CODE = 'missing_emergency_contact_name';
}