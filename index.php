<?php
	require 'vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('file.xlsx') ;
	$worksheet = $spreadsheet->getActiveSheet();
	//Set header row number
	$header=15;

    if (!empty($header)) {
	  	$highestRow = $worksheet->getHighestRow();
		$rowStart = $header;	   
	    $highestColumn = $worksheet->getHighestColumn();
		$movements = $worksheet->rangeToArray('B'.$rowStart.':' . $highestColumn . $rowStart, null, true, true, true);
		$movements = array_filter($movements[$rowStart]); //remove empty & get first
		print_r($movements);
        $i = -1;
        $namedDataArray = array();
        for ($row = $rowStart+1 ; $row <= $highestRow; ++$row) {
            $dataRow = $worksheet->rangeToArray('B'.$row.':' . $highestColumn . $row, null, true, true, true);
			if ((isset($dataRow[$row]['B'])) && ($dataRow[$row]['B'] > '')) {
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