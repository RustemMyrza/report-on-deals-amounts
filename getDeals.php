<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents('php://input');

    $allData = json_decode($json_data, true);
    writeToLog('$allData', $allData);
    $id_data = $allData['id'];
    $quarter_data = $allData['quarter'];
    $year_data = $allData['year'];
    if (json_last_error() === JSON_ERROR_NONE) {
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(405);
}





$hook = "";     #Your webhook
$methodDealList = "crm.deal.list";
$methodDealGet = "crm.deal.get";
foreach ($id_data as $key => $value) {
    if ($quarter_data == 'I') {
        $params =
            [
                'FILTER' =>
                    [
                        '>=DATE_CREATE' => $year_data . '-01-01' . 'T00:00:00',
                        '<=DATE_CREATE' => $year_data . '-04-01' . 'T00:00:00',
                        'ASSIGNED_BY_ID' => $value
                    ]
            ];
    } else if ($quarter_data == 'II') {
        $params =
            [
                'FILTER' =>
                    [
                        '>=DATE_CREATE' => $year_data . '-04-01' . 'T00:00:00',
                        '<=DATE_CREATE' => $year_data . '-07-01' . 'T00:00:00',
                        'ASSIGNED_BY_ID' => $value
                    ]
            ];
    } else if ($quarter_data == 'III') {
        $params =
            [
                'FILTER' =>
                    [
                        '>=DATE_CREATE' => $year_data . '-07-01' . 'T00:00:00',
                        '<=DATE_CREATE' => $year_data . '-10-01' . 'T00:00:00',
                        'ASSIGNED_BY_ID' => $value
                    ]
            ];
    } else if ($quarter_data == 'IV') {
        $params =
            [
                'FILTER' =>
                    [
                        '>=DATE_CREATE' => $year_data . '-10-01' . 'T00:00:00',
                        '<=DATE_CREATE' => $year_data . '-12-31' . 'T23:59:59',
                        'ASSIGNED_BY_ID' => $value
                    ]
            ];
    }



    $ch = curl_init($hook . $methodDealList . '?' . http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $response = json_decode($response);
    $result[] = $response;

    if (curl_errno($ch)) {
        echo 'Ошибка CURL: ' . curl_error($ch);
        writeToLog("ERROR crm.deal.list", curl_error($ch));
    }
    curl_close($ch);
}
writeToLog("result crm.deal.list", $result);



$usersDeals = [];
foreach ($result as $key => $value) {
    if ($value->total > 0) {
        writeToLog('Its HAS THE DEALS', $value->total);
        foreach ($value as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                $usersDeals[$value2->ASSIGNED_BY_ID][] = $value2->ID;
            }
        }
    } else {
        writeToLog('Its HAS NO DEALS', $value->total);
    }
}

unset($usersDeals['']);


writeToLog("usersDeals", $usersDeals);

$result = [];
foreach ($usersDeals as $key => $value) {
    foreach ($value as $key1 => $value1) {
        $param = [
            'ID' => $value1
        ];
        $ch = curl_init($hook . $methodDealGet . '?' . http_build_query($param));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        $result[] = $response;

        if (curl_errno($ch)) {
            echo 'Ошибка CURL: ' . curl_error($ch);
            writeToLog("ERROR crm.deal.get", curl_error($ch));
        }
        curl_close($ch);
    }
}
writeToLog("result crm.deal.get", $result);

if (count($result) > 0) {
    foreach ($result as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $usersMargin[$value1->ASSIGNED_BY_ID] += intval($value1->UF_CRM_1695102448106);
        }
    }
    unset($usersMargin['']);
} else {
    $usersMargin = [
        0 => 0
    ];
}
writeToLog("usersMargin", $usersMargin);
echo json_encode($usersMargin);



function writeToLog($data1, $data2)
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= print_r($data1, 1);
    $log .= "\n------------------------\n";
    $log .= print_r($data2, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/send.log', $log, FILE_APPEND);
    return true;
}

?>
