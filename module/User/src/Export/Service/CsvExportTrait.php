<?php

namespace User\Export\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * CsvExport Trait
 */
trait CsvExportTrait
{
    /**
     * @var \User\Export\Service\csvExport
     */
    protected $csvExportService;

    /**
     * Get the value of csvExportService
     *
     * @return  \User\Export\Service\csvExport
     */
    public function getCsvExportService()
    {
        return $this->csvExportService;
    }

    /**
     * Set the value of csvExportService
     *
     * @param  \User\Export\Service\csvExport  $csvExportService
     *
     * @return  self
     */
    public function setCsvExportService(\User\Export\Service\csvExport $csvExportService)
    {
        $this->csvExportService = $csvExportService;

        return $this;
    }
}
