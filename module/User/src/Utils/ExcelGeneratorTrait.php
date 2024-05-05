<?php

namespace User\Utils;

use DateTime;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Receipt\Entity\Receipt;

trait ExcelGeneratorTrait
{
  protected function generate(\DateTime $beginDate, \DateTime $endDate, $data)
  {
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('Xtend Indonesia')
      ->setLastModifiedBy('Xtend Indonesia')
      ->setTitle('Delivery Order Report')
      ->setSubject('Delivery Order Report')
      ->setDescription('')
      ->setKeywords('')
      ->setCategory('Report');

    $beginDatePeriod = $beginDate->format('d/m/Y');
    $endDatePeriod = $endDate->format('d/m/Y');

    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
      ->mergeCells('A1:I1')
      ->setCellValue('A1', 'DELIVERY ORDER REPORT  ----  ' . $beginDatePeriod . 'TO' . $endDatePeriod)
      ->setCellValue('A2', 'NUMBER')
      ->setCellValue('B2', 'CUSTOMER')
      ->setCellValue('C2', 'CREATED BY')
      ->setCellValue('D2', 'CREATED AT')
      ->setCellValue('E2', 'SHIPPED BY')
      ->setCellValue('F2', 'SHIPPED AT')
      ->setCellValue('G2', 'RECEIVED BY')
      ->setCellValue('H2', 'RECEIVED AT')
      ->setCellValue('I2', 'STATUS');

    $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray([
      'font' => [
        'bold' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color'       => ['argb', 'FF000000'],
        ],
      ]
    ]);
    $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray([
      'font' => [
        'bold' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color'       => ['argb', 'FF000000'],
        ],
      ]
    ]);

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);


    $row = 3;
    $receiptData = [];
    $worksheet = $spreadsheet->getActiveSheet();
    foreach ($data as $receipt) {
      if ($receipt instanceof Receipt) {
        $receiptData = [
          'number'    => (string)$receipt->getNumber(),
          'customer'  => (string)$receipt->getCustomer()->getName(),
          'createdBy'        => (string)!is_null($receipt->getCreatedBy()) ? $receipt->getCreatedBy()->getFirstName() . ' ' . $receipt->getCreatedBy()->getLastName()  : '-',
          'createdAt'      => !is_null($receipt->getCreatedAt()) ? $receipt->getCreatedAt()->format('Y-m-d H:i:s') : '-',
          'shippedBy'        => (string)!is_null($receipt->getShippedBy()) ? $receipt->getShippedBy()->getFirstName() . ' ' . $receipt->getShippedBy()->getLastName()  : '-',
          'shippedAt'      => !is_null($receipt->getShippedAt()) ? $receipt->getShippedAt()->format('Y-m-d H:i:s') : '-',
          'receivedBy'        => (string)!is_null($receipt->getReceivedBy()) ? $receipt->getReceivedBy() : '-',
          'receivedAt'      => !is_null($receipt->getReceivedAt()) ? $receipt->getReceivedAt()->format('Y-m-d H:i:s') : '-',
          'status'        => $receipt->getStatus(),
        ];
      }
      $worksheet
        ->setCellValue('A' . $row, $receiptData['number'])
        ->setCellValue('B' . $row, $receiptData['customer'])
        ->setCellValue('C' . $row, $receiptData['createdBy'])
        ->setCellValue('D' . $row, $receiptData['createdAt'])
        ->setCellValue('E' . $row, $receiptData['shippedBy'])
        ->setCellValue('F' . $row, $receiptData['shippedAt'])
        ->setCellValue('G' . $row, $receiptData['receivedBy'])
        ->setCellValue('H' . $row, $receiptData['receivedAt'])
        ->setCellValue('I' . $row, $receiptData['status']);

      $worksheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color'       => ['argb', 'FF000000'],
          ],
        ]
      ]);
      $row++;
    }


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    return $spreadsheet;
  }

  protected function setWriterOutput($spreadsheet)
  {
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $path = '/tmp/attendance-report-' . microtime(true) . '.xlsx';
    // $path = 'php://output';
    $writer->save($path);

    return $path;
  }
}
