<?php
require "vendor/autoload.php";
$wb = PhpOffice\PhpSpreadsheet\IOFactory::load("storage/app/tmp_import_check.xlsx");
$ws = $wb->getActiveSheet();
$sumD = 0; $sumIT = 0; $sumExc = 0; $sumTax = 0; $sumExt = 0; $sumAmt = 0; $sumAllIT = 0; $maxR = (int)$ws->getHighestRow();
for ($r = 2; $r <= 9; $r++) {
  $sumD += (float)$ws->getCellByColumnAndRow(19, $r)->getCalculatedValue();
  $sumIT += (float)$ws->getCellByColumnAndRow(23, $r)->getCalculatedValue();
  $sumExc += (float)$ws->getCellByColumnAndRow(17, $r)->getCalculatedValue();
  $sumTax += (float)$ws->getCellByColumnAndRow(14, $r)->getCalculatedValue();
  $sumExt += (float)$ws->getCellByColumnAndRow(16, $r)->getCalculatedValue();
  $sumAmt += (float)$ws->getCellByColumnAndRow(24, $r)->getCalculatedValue();
}
for ($r = 2; $r <= $maxR; $r++) {
  $sumAllIT += (float)$ws->getCellByColumnAndRow(23, $r)->getCalculatedValue();
}
echo "inv disc=$sumD incomeTax=$sumIT exc=$sumExc tax=$sumTax ext=$sumExt amt=$sumAmt\n";
echo "fileAllIncomeTax=$sumAllIT rows=$maxR\n";
