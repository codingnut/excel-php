<?php
	require 'vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('file.xlsx') ;
	$worksheet = $spreadsheet->getActiveSheet();
	//Set header row number
    $header=15;
    $startCell = 'B';

    if (!empty($header)) {
	  	$highestRow = $worksheet->getHighestRow();
		$rowStart = $header;	   
	    $highestColumn = $worksheet->getHighestColumn();
		$movements = $worksheet->rangeToArray($startCell.$rowStart.':' . $highestColumn . $rowStart, null, true, true, true);
		$movements = array_filter($movements[$rowStart]); //remove empty & get first
		print_r($movements);
        $i = -1;
        $namedDataArray = array();
        for ($row = $rowStart+1 ; $row <= $highestRow; ++$row) {
            $dataRow = $worksheet->rangeToArray($startCell.$row.':' . $highestColumn . $row, null, true, true, true);
			if ((isset($dataRow[$row][$startCell])) && ($dataRow[$row][$startCell] > '')) {
                ++$i;
                foreach ($movements as $columnKey => $columnHeading) {
                    $namedDataArray[$i][$columnHeading] = $dataRow[$row][$columnKey];
                }
            }
        }
    } else {  
       $namedDataArray = $worksheet->toArray(null, true, true, true);
   }
    echo '<pre>';print_r($namedDataArray);exit;
?>