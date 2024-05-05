<?php

namespace Xtend\Export\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * CsvExport Trait
 */
trait CsvExportTrait
{
    /**
     * @var \Xtend\Export\Service\csvExport
     */
    protected $csvExportService;

    /**
     * Get the value of csvExportService
     *
     * @return  \Xtend\Export\Service\csvExport
     */
    public function getCsvExportService()
    {
        return $this->csvExportService;
    }

    /**
     * Set the value of csvExportService
     *
     * @param  \Xtend\Export\Service\csvExport  $csvExportService
     *
     * @return  self
     */
    public function setCsvExportService(\Xtend\Export\Service\csvExport $csvExportService)
    {
        $this->csvExportService = $csvExportService;

        return $this;
    }
}
