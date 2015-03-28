<?php
/*
   * Collect all Details from Angular HTTP Request.
   */
$postdata = file_get_contents("php://input");
//$request = json_decode($postdata);

$json1 = json_decode(file_get_contents("data.json"), true);
$json2 = json_decode($postdata, true);
error_log(json_encode($json2));

//FIXME : recursive !!
foreach ($json2['data'] as $keyNb => $entryNb) {
    foreach ($json2['data'][$keyNb] as $keyYear => $entryYear) {
        foreach ($json2['data'][$keyNb][$keyYear] as $keyMonth => $entryMonth) {
            foreach ($json2['data'][$keyNb][$keyYear][$keyMonth] as $keyDay => $entryDay) {
                if ($entryDay != "") {
                    if (!array_key_exists($keyYear, $json1['data'][$keyNb])) {
                        error_log("Create Year " . $keyYear);
                        $json1['data'][$keyNb][$keyYear] = $entryYear;
                    }
                    if (!array_key_exists($keyMonth, $json1['data'][$keyNb][$keyYear])) {
                        error_log("Create Month " . $keyMonth);
                        $json1['data'][$keyNb][$keyYear][$keyMonth] = $entryMonth;
                    }
                    error_log("Create/update Day " . $keyDay);
                    $json1['data'][$keyNb][$keyYear][$keyMonth][$keyDay] = $entryDay;
                } else {
                    if (array_key_exists($keyDay, $json1['data'][$keyNb][$keyYear][$keyMonth])) {
                        error_log("Delete day " . $keyYear . "/" . $keyMonth . "/" . $keyDay . " from json source");
                        unset($json1['data'][$keyNb][$keyYear][$keyMonth][$keyDay]);
                        if (count($json1['data'][$keyNb][$keyYear][$keyMonth]) == 0) {
                            error_log("Delete month " . $keyYear . "/" . $keyMonth . " from json source");
                            unset($json1['data'][$keyNb][$keyYear][$keyMonth]);
                        }
                        if (count($json1['data'][$keyNb][$keyYear]) == 0) {
                            error_log("Delete year " . $keyYear . " from json source");
                            unset($json1['data'][$keyNb][$keyYear]);
                        }
                    }
                }
            }
        }
    }
}
file_put_contents("data.json", json_encode($json1));
