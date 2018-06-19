<?php

namespace App\Services\CSVImporter;

use App\CSVRow;

class CSVImportTraveler
{

    /**
     * @var CSVRow
     */
    private $row;

    private $participant;

    /**
     * @param CSVRow $row
     * @return CSVImportTraveler
     */
    public function setRow(CSVRow $row): CSVImportTraveler
    {
        $this->row = $row;

        return $this;
    }

    /**
     * @return CSVRow
     */
    public function getRow(): CSVRow
    {
        return $this->row;
    }

    /**
     * @return mixed
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param mixed $participant
     * @return CSVImportTraveler
     */
    public function setParticipant($participant): CSVImportTraveler
    {
        $this->participant = $participant;

        return $this;
    }
}