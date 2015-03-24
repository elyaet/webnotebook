<?php
/*
   * Collect all Details from Angular HTTP Request.
   */
$postdata = file_get_contents("php://input");
//$request = json_decode($postdata);

$json1 = json_decode(file_get_contents("data-light.json"), true);
$json2 = json_decode($postdata, true);
error_log(json_encode($json2));

//FIXME : recursive !!
foreach ($json2['data'] as $keyNb => $entryNb) {
    foreach ($json2['data'][$keyNb] as $keyYear => $entryYear) {
        if (!array_key_exists($keyYear, $json1['data'][$keyNb])) {
            error_log("inside Year");
            $json1['data'][$keyNb][$keyYear] = $entryYear;
        } else {
            foreach ($json2['data'][$keyNb][$keyYear] as $keyMonth => $entryMonth) {
                if (!array_key_exists($keyMonth, $json1['data'][$keyNb][$keyYear])) {
                    error_log("inside Month");
                    $json1['data'][$keyNb][$keyYear][$keyMonth] = $entryMonth;
                } else {
                    foreach ($json2['data'][$keyNb][$keyYear][$keyMonth] as $keyDay => $entryDay) {
                        error_log("inside Day");
                        $json1['data'][$keyNb][$keyYear][$keyMonth][$keyDay] = $entryDay;
                    }
                }
            }
        }
    }
}

file_put_contents("data-light.json", json_encode($json1));
