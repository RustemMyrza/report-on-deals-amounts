<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>План продаж</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/6335/6335589.png" />
</head>

<body>
    <?php
    $webhook = "";      #Your webhook
    $method = 'user.get';


    $params = array(
        'select' => ['ID', 'NAME', 'SECOND_NAME'],

        'FILTER' => array(

            '>ID' => 0,
        ),
    );

    $queryUrl = $webhook . $method;
    $queryData = http_build_query($params);

    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_SSL_VERIFYPEER => 0,

            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        )
    );

    $result1 = curl_exec($curl);
    curl_close($curl);
    $result1 = json_decode($result1);
    foreach ($result1->result as $key => $value) {
        if ($value->NAME == '') {
            unset($result1->result[$key]);
        }
    }
    ?>
    <?php
    $method_lists_element_get = 'lists.element.get';
    $quarters = ['I', 'II', 'III', 'IV'];


    $params = [
        'IBLOCK_TYPE_ID' => 'lists',
        'IBLOCK_ID' => 30,
    ];

    $ch = curl_init($webhook . $method_lists_element_get);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        die(curl_error($ch));
    }

    curl_close($ch);


    $resultFromList = json_decode($response, true);

    if ($resultFromList === null) {
        die('Error decoding JSON response');
    }
    $fromListUsersId = [];
    foreach ($resultFromList['result'] as $key => $value) {
        $fromListUsersId[array_values($value['PROPERTY_122'])[0]][array_values($value['PROPERTY_116'])[0]]['plannedMargin'] = array_values($value['PROPERTY_118'])[0];
        $fromListUsersId[array_values($value['PROPERTY_122'])[0]][array_values($value['PROPERTY_116'])[0]]['year'] = array_values($value['PROPERTY_124'])[0];
        $fromListUsersId[array_values($value['PROPERTY_122'])[0]][array_values($value['PROPERTY_116'])[0]]['avatar'] = array_values($value['PROPERTY_126'])[0];
        foreach ($result1->result as $key1 => $value1) {
            if ($value1->ID == array_values($value['PROPERTY_116'])[0]) {
                $fromListUsersId[array_values($value['PROPERTY_122'])[0]][array_values($value['PROPERTY_116'])[0]]['name'] = $value1->NAME . ' ' . $value1->LAST_NAME;
            }
        }
    }
    $methodDealList = "crm.deal.list";
    for ($i = 0; $i < count($quarters); $i++) {
        if (isset($fromListUsersId[$quarters[$i]])) {
            foreach ($fromListUsersId[$quarters[$i]] as $key => $value) {
                if ($quarters[$i] == 'I') {
                    $params =
                        [
                            'FILTER' =>
                                [
                                    '>=DATE_CREATE' => $value['year'] . '-01-01' . 'T00:00:00',
                                    '<=DATE_CREATE' => $value['year'] . '-04-01' . 'T00:00:00',
                                    'ASSIGNED_BY_ID' => $key
                                ]
                        ];
                    $ch = curl_init($webhook . $methodDealList . '?' . http_build_query($params));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = json_decode($response);
                    $resultOfDealList['I'][] = $response;

                    if (curl_errno($ch)) {
                        echo 'Ошибка CURL: ' . curl_error($ch);
                    }
                    curl_close($ch);
                } else if ($quarters[$i] == 'II') {
                    $params =
                        [
                            'FILTER' =>
                                [
                                    '>=DATE_CREATE' => $value['year'] . '-04-01' . 'T00:00:00',
                                    '<=DATE_CREATE' => $value['year'] . '-07-01' . 'T00:00:00',
                                    'ASSIGNED_BY_ID' => $key
                                ]
                        ];
                    $ch = curl_init($webhook . $methodDealList . '?' . http_build_query($params));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = json_decode($response);
                    $resultOfDealList['II'][] = $response;

                    if (curl_errno($ch)) {
                        echo 'Ошибка CURL: ' . curl_error($ch);
                    }
                    curl_close($ch);
                } else if ($quarters[$i] == 'III') {
                    $params =
                        [
                            'FILTER' =>
                                [
                                    '>=DATE_CREATE' => $value['year'] . '-07-01' . 'T00:00:00',
                                    '<=DATE_CREATE' => $value['year'] . '-10-01' . 'T00:00:00',
                                    'ASSIGNED_BY_ID' => $key
                                ]
                        ];
                    $ch = curl_init($webhook . $methodDealList . '?' . http_build_query($params));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = json_decode($response);
                    $resultOfDealList['III'][] = $response;

                    if (curl_errno($ch)) {
                        echo 'Ошибка CURL: ' . curl_error($ch);
                    }
                    curl_close($ch);
                } else if ($quarters[$i] == 'IV') {
                    $params =
                        [
                            'FILTER' =>
                                [
                                    '>=DATE_CREATE' => $value['year'] . '-10-01' . 'T00:00:00',
                                    '<=DATE_CREATE' => $value['year'] . '-12-31' . 'T00:00:00',
                                    'ASSIGNED_BY_ID' => $key
                                ]
                        ];
                    $ch = curl_init($webhook . $methodDealList . '?' . http_build_query($params));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = json_decode($response);
                    $resultOfDealList['IV'][] = $response;

                    if (curl_errno($ch)) {
                        echo 'Ошибка CURL: ' . curl_error($ch);
                    }
                    curl_close($ch);
                }
            }
        }

    }

    $usersDeals = [];
    foreach ($resultOfDealList as $key => $value) {
        foreach ($value as $key1 => $value1) {
            if (count($value1->result) > 0) {
                foreach ($value1->result as $key2 => $value2) {
                    $usersDeals[$key][$value2->ASSIGNED_BY_ID][] = $value2->ID;
                }
            }
        }
    }
    $result = [];
    $methodDealGet = "crm.deal.get";
    foreach ($usersDeals as $key => $value) {
        foreach ($value as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                $param = [
                    'ID' => $value2
                ];
                $ch = curl_init($webhook . $methodDealGet . '?' . http_build_query($param));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $response = json_decode($response);
                $result[$key][] = $response;

                if (curl_errno($ch)) {
                    echo 'Ошибка CURL: ' . curl_error($ch);
                }
                curl_close($ch);
            }
        }
    }
    foreach ($result as $key => $value) {
        foreach ($value as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2)
                if ($value2->ASSIGNED_BY_ID == '') {
                } else {
                    $usersMargin[$key][$value2->ASSIGNED_BY_ID] += intval($value2->yourFieldName);   //There have be your field name
                }
        }
    }
    foreach ($usersMargin as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $percentOfCompleted[$key][$key1] = (intval($usersMargin[$key][$key1]) / intval($fromListUsersId[$key][$key1]['plannedMargin'])) * 100;
        }
    }
    foreach ($fromListUsersId as $key => $value) {
        foreach ($value as $key1 => $value1) {
            if (isset($usersMargin[$key][$key1])) {
                $fromListUsersId[$key][$key1]['marginMade'] = $usersMargin[$key][$key1];
                $fromListUsersId[$key][$key1]['marginPercent'] = $percentOfCompleted[$key][$key1];
            } else {
                $fromListUsersId[$key][$key1]['marginMade'] = 0;
                $fromListUsersId[$key][$key1]['marginPercent'] = 0;
            }
        }
    }
    $sumOfMargin = [];
    $sumOfPlan = [];
    foreach ($usersMargin as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $sumOfMargin[$key] += intval($value1);
        }
    }
    foreach ($fromListUsersId as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $sumOfPlan[$key] += intval($fromListUsersId[$key][$key1]['plannedMargin']);
        }
    }

    $methodDepartmentGet = 'department.get';
    $ch = curl_init($webhook . $methodDepartmentGet);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $response = json_decode($response);
    $resultOfDepartments[] = $response;
    $resultOfDepartments = $resultOfDepartments[0]->result;

    if (curl_errno($ch)) {
        echo 'Ошибка CURL: ' . curl_error($ch);
    }
    curl_close($ch);




    $departments = [];
    foreach ($resultOfDepartments as $key => $value) {
        $departments[$value->ID]['NAME'] = $value->NAME;
    }
    foreach ($result1->result as $key => $value) {
        if (isset($departments[$value->UF_DEPARTMENT[0]]))
            $departments[$value->UF_DEPARTMENT[0]]['EMPLOYEES'][$value->ID]['NAME'] = $value->NAME . ' ' . $value->LAST_NAME;
        if (isset($value->PERSONAL_PHOTO)) {
            $value->PERSONAL_PHOTO = explode(' ', $value->PERSONAL_PHOTO);
            $value->PERSONAL_PHOTO = implode('%20', $value->PERSONAL_PHOTO);
            $departments[$value->UF_DEPARTMENT[0]]['EMPLOYEES'][$value->ID]['AVATAR'] = $value->PERSONAL_PHOTO;
        } else {
            $departments[$value->UF_DEPARTMENT[0]]['EMPLOYEES'][$value->ID]['AVATAR'] = 'data:image/svg+xml;charset=US-ASCII,%3Csvg%20viewBox%3D%220%200%2089%2089%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Ccircle%20fill%3D%22%23535C69%22%20cx%3D%2244.5%22%20cy%3D%2244.5%22%20r%3D%2244.5%22/%3E%3Cpath%20d%3D%22M68.18%2071.062c0-3.217-3.61-16.826-3.61-16.826%200-1.99-2.6-4.26-7.72-5.585-1.734-.483-3.383-1.233-4.887-2.223-.33-.188-.28-1.925-.28-1.925l-1.648-.25c0-.142-.14-2.225-.14-2.225%201.972-.663%201.77-4.574%201.77-4.574%201.252.695%202.068-2.4%202.068-2.4%201.482-4.3-.738-4.04-.738-4.04.388-2.625.388-5.293%200-7.918-.987-8.708-15.847-6.344-14.085-3.5-4.343-.8-3.352%209.082-3.352%209.082l.942%202.56c-1.85%201.2-.564%202.65-.5%204.32.09%202.466%201.6%201.955%201.6%201.955.093%204.07%202.1%204.6%202.1%204.6.377%202.556.142%202.12.142%202.12l-1.786.217c.024.58-.023%201.162-.14%201.732-2.1.936-2.553%201.485-4.64%202.4-4.032%201.767-8.414%204.065-9.193%207.16-.78%203.093-3.095%2015.32-3.095%2015.32H68.18z%22%20fill%3D%22%23FFF%22/%3E%3C/svg%3E';
        }

    }

    ?>
    <script>
        console.log("OK")
        function showDiv(element) {
            console.log(element.children[1].classList)
            console.log(element.children[1])
            if (element.children[1].classList.contains('crm-start-graph-content-open')) {
                console.log(element.children[1].classList.contains('crm-start-graph-content-open'))
                element.children[1].classList.remove('crm-start-graph-content-open');
            }
            else {
                console.log(element.children[1].classList.contains('crm-start-graph-content-open'))
                element.children[1].classList.add('crm-start-graph-content-open');
            }
        }
    </script>
    <?php
    foreach ($quarters as $key => $value) {
        echo "<button>$value квартал</button>";
        echo '
    <div class="plan">
            <div class="ui-side-panel-wrap-below"></div>

            <div class="ui-page-slider-workarea" hidden>
                <div class="ui-side-panel-wrap-sidebar"></div>
                <div id="workarea-content" class="ui-side-panel-wrap-workarea">
                    <div id="report-analytics-page" class="report-analytics-page-wrapper">

                        <div class="report-analytics-content">


                            <div id="report-visualconstructor-board" style="position: relative;">
                                <div class="report-visualconstructor-inner">
                                    <div class="report-visualconstructor-dashboard-container">
                                        <div class="report-visualconstructor-dashboard-row-container"
                                            data-id="VgADAQhZksRV2gIk7NWOiqZkI_1BcHUlvrF" data-weight="1"
                                            data-type="row-container">
                                            <div class="report-visualconstructor-dashboard-row-wrapper"
                                                data-id="VgADAQhZksRV2gIk7NWOiqZkI_1BcHUlvrF" data-type="row-wrapper">
                                                <div
                                                    class="report-visualconstructor-dashboard-row report-visualconstructor-dashboard-row-direction-row">
                                                    <div class="report-visualconstructor-dashboard-cell" data-id="cell_fLTz"
                                                        data-type="cell" style="flex: 1 1 0%; min-height: 323px;">
                                                        <div
                                                            class="report-visualconstructor-dashboard-cell-temp-content report-visualconstructor-dashboard-hidden-temp-content">
                                                            Drop here widget or <ins>create</ins></div>
                                                        <div class="report-visualconstructor-dashboard-widget-container"
                                                            data-id="aph7gZ07lZTNPV7u04XDgWz1x_1VjI4NZlX"
                                                            data-weight="cell_fLTz" data-type="widget">
                                                            <div class="report-visualconstructor-dashboard-widget-wrapper report-visualconstructor-dashboard-widget-light"
                                                                style="background-color: rgb(255, 255, 255);">
                                                                <div class="report-visualconstructor-dashboard-widget-head-container"
                                                                    data-id="aph7gZ07lZTNPV7u04XDgWz1x_1VjI4NZlX"
                                                                    data-weight="cell_fLTz" data-type="widget">
                                                                    <div
                                                                        class="report-visualconstructor-dashboard-widget-head-wrapper">
                                                                        <div
                                                                            class="report-visualconstructor-dashboard-widget-title-container">
                                                                            План продаж</div>
                                                                        <div
                                                                            class="report-visualconstructor-dashboard-widget-controls-container report-visualconstuctor-widget-property-invisible">
                                                                            <div
                                                                                class="report-visualconstructor-dashboard-widget-properties-button">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="report-visualconstructor-properties-in-heed-button">
                                                                            настроить план</div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="report-visualconstructor-dashboard-widget-content-container">
                                                                    <div
                                                                        class="report-visualconstructor-dashboard-widget-content-wrapper">
                                                                        <div style="overflow: hidden;">
                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-main"
                                                                                data-categories="[{&quot;id&quot;:0,&quot;name&quot;:&quot;\u041e\u0431\u0449\u0430\u044f&quot;}]">
                                                                                            <div class="crm-start-row crm-start-row-margin-bottom">
                                                                                                <div class="crm-start-target">
                                                                                                    <span class="crm-start-target-title">Общая цель</span>
                                                                                                    <span class="crm-start-target-total" data-role="total-target"></span>
                                                                                                </div>
                                                                                                <div class="crm-start-target crm-start-target-right">
                                                                                                    <span class="crm-start-target-title">План на период</span>
                                                                                                    <span class="crm-start-target-month">
                                                                                                        <span class="crm-start-target-month-swipe crm-start-target-month-swipe-left" data-role="previous-period"></span>
                                                                                                        <span class="crm-start-target-month-title" data-role="current-period"></span>
                                                                                                        <span class="crm-start-target-month-swipe crm-start-target-month-swipe-right" data-role="next-period"></span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div data-include="widget-saletarget-company" class="crm-start-widget-saletarget-company" data-if="view-type=COMPANY"></div>
                                                                                            <div data-include="widget-saletarget-category" data-if="view-type=CATEGORY"></div>
                                                                                            <div data-include="widget-saletarget-user" data-if="view-type=USER"></div>
                                                                                            <div class="crm-start-row">
                                                                                                <div class="crm-start-row-result">
                                                                                                    <div class="crm-start-row-result-item">
                                                                                                        <div class="crm-start-row-result-item-title">Выполнено</div>
                                                                                                        <div class="crm-start-row-result-item-total" data-role="total-complete"></div>
                                                                                                    </div>
                                                                                                    <div class="crm-start-row-result-item">
                                                                                                        <div class="crm-start-row-result-item-title">Осталось</div>
                                                                                                        <div class="crm-start-row-result-item-total" data-role="total-remaining"></div>
                                                                                                    </div>
                                                                                                    <div class="crm-start-row-result-item">
                                                                                                        <div class="crm-start-row-result-item-title">Выполнение плана</div>
                                                                                                        <div class="crm-start-row-result-item-total">
                                                                                                            <span class="crm-start-row-result-item-total-sum" data-role="total-progress-percent"></span>
                                                                                                            <span>%</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        <script type="text/html"
                                                                                            data-template="widget-saletarget-company">
                                                                                            <div class="crm-start-row">
                                                                                                <div class="crm-start-graph-month-progress" data-role="progress" data-more-class="crm-start-graph-progress-more">
                                                                                                    <div class="crm-start-graph-month-progress-line" style="width: 0" data-role="progress-line"></div>
                                                                                                    <div class="crm-start-graph-progress-total" data-role="progress-total"></div>
                                                                                                    <div class="crm-start-graph-month-progress-point" data-left-class="crm-start-graph-month-progress-point-left" data-right-class="crm-start-graph-month-progress-point-right" style="left: 0;" data-role="progress-point">
                                                                                                        <div class="crm-start-graph-month-progress-baloon">
                                                                                                            <span class="crm-start-graph-month-progress-baloon-day">Сегодня</span>
                                                                                                            <span class="crm-start-graph-month-progress-baloon-date" data-role="today"></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="crm-start-graph-month-scale crm-start-graph-month-scale-28">
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item-first" data-role="first-day"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item-middle"></div>
                                                                                                    <div class="crm-start-graph-month-scale-item-last" data-role="last-day"></div>
                                                                                                </div>
                                                                                            </div>
        </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-category">
        <div data-loop="categories" class="crm-start-row">
            <div class="crm-start-graph-row">
                <div class="crm-start-graph-head crm-start-graph-head-dropdown" data-role="category-row" data-open-class="crm-start-graph-head-open">
                    <div class="crm-start-graph-title">
                        <span class="crm-start-graph-title-link" data-role="category-name"></span>
                    </div>
                    <div class="crm-start-graph-wrapper">
                        <div class="crm-start-graph-progress" data-role="category-progress" data-more-class="crm-start-graph-progress-more">
                            <div class="crm-start-graph-progress-line" style="width: 0" data-role="category-progress-line"></div>
                            <div class="crm-start-graph-progress-total" data-role="category-progress-line-value"></div>
                        </div>
                        <div class="crm-start-graph-total-sum" data-role="category-target"></div>
                        <div class="crm-start-graph-wrapper-line" style="left: 0" data-role="progress-point"></div>
                    </div>
                </div>
                <div class="crm-start-graph-content" data-role="category-target-details" data-open-class="crm-start-graph-content-open">
                    <div class="crm-start-graph-user-plan">
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title">Выполнено</span>
                            <div class="crm-start-graph-user-plan-total" data-role="category-target-current"></div>
                        </div>
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title">Осталось</span>
                            <div class="crm-start-graph-user-plan-total" data-role="category-target-remaining"></div>
                        </div>
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title" >Выполнение плана</span>
                            <div class="crm-start-graph-user-plan-total">
                                <span class="crm-start-graph-user-plan-sum" data-role="category-target-effective"></span>
                                <span class="crm-start-graph-user-plan-symbol">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="crm-start-saletarget-general-progress" data-include="widget-saletarget-general-progress"></div>
    </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-user">
        <div data-loop="users" class="crm-start-row">
            <div class="crm-start-graph-row">
                <div class="crm-start-graph-head crm-start-graph-head-dropdown" data-role="user-row" data-open-class="crm-start-graph-head-open" data-inactive-class="crm-start-graph-head-inactive">
                    <div class="crm-start-graph-title">
                        <div class="crm-start-graph-title-avatar" data-role="user-photo"></div>
                        <div class="crm-start-graph-title-user">
                            <span class="crm-start-graph-title-link" data-role="user-name"></span>
                            <span class="crm-start-graph-title-position" data-role="user-title"></span>
                        </div>
                    </div>
                    <div class="crm-start-graph-wrapper">
                        <div class="crm-start-graph-progress" data-role="user-progress" data-more-class="crm-start-graph-progress-more">
                            <div class="crm-start-graph-progress-line" style="width: 0" data-role="user-progress-line"></div>
                            <div class="crm-start-graph-progress-total" data-role="user-progress-line-value"></div>
                        </div>
                        <div class="crm-start-graph-total-sum" data-role="user-target"></div>
                        <div class="crm-start-graph-wrapper-line" style="left: 0" data-role="progress-point"></div>
                    </div>
                </div>
                <div class="crm-start-graph-content" data-role="user-target-details" data-open-class="crm-start-graph-content-open">
                    <div class="crm-start-graph-user-plan">
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title">Выполнено</span>
                            <div class="crm-start-graph-user-plan-total" data-role="user-target-current"></div>
                        </div>
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title">Осталось</span>
                            <div class="crm-start-graph-user-plan-total" data-role="user-target-remaining"></div>
                        </div>
                        <div class="crm-start-graph-user-plan-item">
                            <span class="crm-start-graph-user-plan-title" >Выполнение плана</span>
                            <div class="crm-start-graph-user-plan-total">
                                <span class="crm-start-graph-user-plan-sum" data-role="user-target-effective"></span>
                                <span class="crm-start-graph-user-plan-symbol">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="crm-start-saletarget-general-progress" data-include="widget-saletarget-general-progress"></div>
    </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-general-progress">
        <div class="crm-start-row crm-start-row-flex">
            <div class="crm-start-graph-title" data-if="view-type=CATEGORY">
                <span class="crm-start-graph-title-text">Выполнение плана по направлениям</span>
            </div>
            <div class="crm-start-graph-title" data-if="view-type=USER">
                <span class="crm-start-graph-title-text">Выполнение плана сотрудниками</span>
            </div>
            <div class="crm-start-graph-wrapper">
                <div class="crm-start-graph-month-progress" data-role="progress" data-more-class="crm-start-graph-progress-more">
                    <div class="crm-start-graph-month-progress-line" style="width: 0" data-role="progress-line"></div>
                    <div class="crm-start-graph-progress-total" data-role="progress-total"></div>
                    <div class="crm-start-graph-month-progress-point" data-left-class="crm-start-graph-month-progress-point-left" data-right-class="crm-start-graph-month-progress-point-right" style="left: 0;" data-role="progress-point">
                        <div class="crm-start-graph-month-progress-baloon">
                            <span class="crm-start-graph-month-progress-baloon-day">Сегодня</span>
                            <span class="crm-start-graph-month-progress-baloon-date" data-role="today"></span>
                        </div>
                    </div>
                </div>
                <div class="crm-start-graph-month-scale crm-start-graph-month-scale-28">
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item"></div>
                    <div class="crm-start-graph-month-scale-item-first" data-role="first-day"></div>
                    <div class="crm-start-graph-month-scale-item-middle"></div>
                    <div class="crm-start-graph-month-scale-item-last" data-role="last-day"></div>
                </div>
            </div>
        </div>
    </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-config">
        <form data-role="form">
            <div class="crm-start-popup-row crm-start-popup-row-border">
                <div class="crm-start-popup-row-title">
                    <span class="crm-start-popup-text">Выберите период на выполнение плана:</span>
                </div>
                <div class="crm-start-popup-row-content">
                    <table>
                        <tr>
                            <td><span class="crm-start-popup-link" data-role="period-type"></span></td>
                            <td>
                                <div class="crm-start-dropdown" data-role="period-month">
                                    <span class="crm-start-dropdown-text" data-role="period-month-value"></span>
                                </div>
                                <div class="crm-start-dropdown" data-role="period-quarter">
                                    <span class="crm-start-dropdown-text" data-role="period-quarter-value"></span>
                                </div>
                                <div class="crm-start-dropdown" data-role="period-half">
                                    <span class="crm-start-dropdown-text" data-role="period-half-value"></span>
                                </div>
                            </td>
                            <td>
                                <div class="crm-start-dropdown" data-role="period-year">
                                    <span class="crm-start-dropdown-text" data-role="period-year-value"></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="crm-start-popup-row crm-start-popup-row-border">
                <div class="crm-start-popup-row-title">
                    <span class="crm-start-popup-text">Укажите цель для плана продаж:</span>
                </div>
                <div class="crm-start-popup-row-content">
                    <div class="crm-start-dropdown" data-role="target-type">
                        <span class="crm-start-dropdown-text" data-role="target-type-value"></span>
                    </div>
                </div>
            </div>
            <div class="crm-start-popup-row crm-start-popup-row-border crm-start-popup-row-margin-bottom">
                <div class="crm-start-popup-row-title">
                    <span class="crm-start-popup-text">Вид плана:</span>
                </div>
                <div class="crm-start-popup-row-content">
                    <div class="crm-start-dropdown" data-role="view-type">
                        <span class="crm-start-dropdown-text" data-role="view-type-value"></span>
                    </div>
                </div>
            </div>
            <div data-role="view-type-content"></div>
            <div class="crm-start-popup-row crm-start-popup-row-block">
                <a target="_blank" href="/crm/configs/deal_category/" class="crm-start-popup-config" data-role="categories-link" style="display: none">Настроить направления</a>
                <span class="crm-start-popup-copy" data-role="copy-configuration"></span>
            </div>
        </form>
    </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-config-user">
        <div data-loop="users" class="crm-start-popup-users">
            <div class="crm-start-popup-row" data-new-class="crm-start-popup-row-new" data-remove-class="crm-start-popup-row-remove" data-inactive-class="crm-start-popup-row-inactive">
                <div class="crm-start-popup-personal">
                    <div class="crm-start-popup-personal-title">
                        <div class="crm-start-popup-personal-title-wrapper">
                            <div class="crm-start-popup-personal-title-avatar" data-role="user-photo"></div>
                            <div class="crm-start-popup-personal-title-info">
                                <span class="crm-start-popup-personal-title-name" data-role="user-name"></span>
                                <span class="crm-start-popup-personal-title-position" data-role="user-title"></span>
                            </div>
                        </div>
                    </div>
                    <div class="crm-start-popup-personal-content">
                        <input type="text" class="crm-start-popup-input" data-role="user-target" placeholder="Например: 50 000">
                    </div>
                </div>
                <div class="crm-start-popup-personal-remove" data-role="user-remove"></div>
            </div>
        </div>
        <div class="crm-start-popup-row crm-start-popup-row-border">
            <span class="crm-start-popup-link crm-start-popup-link-plus" data-role="user-add">добавить еще</span>
        </div>
    </script>

                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-config-category">
        <div data-loop="categories" class="crm-start-popup-row-border">
            <div class="crm-start-popup-row">
                <div class="crm-start-popup-personal">
                    <div class="crm-start-popup-personal-title">
                        <span class="crm-start-popup-personal-title-name" data-role="category-name"></span>
                    </div>
                    <div class="crm-start-popup-personal-content">
                        <input type="text" class="crm-start-popup-input" data-role="category-target" placeholder="Например: 50 000">
                    </div>
                </div>
            </div>
        </div>
    </script>
                                                                            <script type="text/html"
                                                                                data-template="widget-saletarget-config-company">
        <div class="crm-start-popup-row crm-start-popup-row-border">
            <div class="crm-start-popup-row-title">
                <span class="crm-start-popup-text">Укажите цель:</span>
            </div>
            <div class="crm-start-popup-row-content">
                <input type="text" class="crm-start-popup-input" data-role="company-target" placeholder="Например: 50 000">
            </div>
        </div>
    </script>

                                                                            <div data-role="vc-widget-content-salestarget">
                                                                                <div>
                                                                                    <div
                                                                                        class="crm-start-row crm-start-row-margin-bottom">
                                                                                        <div class="crm-start-target">
                                                                                            <span
                                                                                                class="crm-start-target-title">Общая
                                                                                                цель</span>
                                                                                            <span
                                                                                                class="crm-start-target-total"
                                                                                                data-role="total-target">
    ';
        echo $sumOfPlan[$value];
        echo '<span>
    тенге</span></span>
</div>
<div
class="crm-start-target crm-start-target-right">
<span
class="crm-start-target-title">План
на период</span>
<span
class="crm-start-target-month">

<span
    class="crm-start-target-month-title"
    data-role="current-period">';
        echo "$value квартал $yearValue";
        echo '</span>

    </span>
</div>
</div>


<div data-include="widget-saletarget-user"
data-if="view-type=USER">
<div>
    <div data-loop="users"
        class="crm-start-row">';
        if (count($fromListUsersId[$value]) > 0) {
            foreach ($fromListUsersId[$value] as $key1 => $value1) {
                if ($value1['marginPercent'][0] > 100) {

                    echo '
<div class="crm-start-graph-row" onclick="showDiv(this)" aqua_id = "';
                    echo strval($key1);
                    echo ' ">';
                    echo '<div class = "crm-start-graph-head crm-start-graph-head-dropdown" data-role="user-row" data-open-class="crm-start-graph-head-open" data-inactive-class="crm-start-graph-head-inactive">
<div class="crm-start-graph-title">
<div class="crm-start-graph-title-avatar" data-role="user-photo" style="background-image:url(';
                    echo $value1['avatar'];
                    echo ')"></div>
<div class="crm-start-graph-title-user">
<span class="crm-start-graph-title-link" data-role="user-name">';
                    echo $value1['name'];
                    echo '</span>
<span class="crm-start-graph-title-position" data-role="user-title"></span>
</div>
</div>
<div class="crm-start-graph-wrapper">
<div class="crm-start-graph-progress" data-role="user-progress" data-more-class="crm-start-graph-progress-more">
<div class="crm-start-graph-progress-line" style="width: 100%" data-role="user-progress-line"></div>
<div class="crm-start-graph-progress-total" style="position: absolute; z-index: 1000; right: 0;" data-role="user-progress-line-value">';
                    echo strval(round($value1['marginPercent']));
                    echo '<span></span></div>
</div>
<div class="crm-start-graph-total-sum" data-role="user-target">';
                    echo strval(round($value1['plannedMargin']));

                } else {
                    echo '
<div class="crm-start-graph-row" onclick="showDiv(this)" aqua_id = "';
                    echo strval($key1);
                    echo ' ">';
                    echo '<div class = "crm-start-graph-head crm-start-graph-head-dropdown" data-role="user-row" data-open-class="crm-start-graph-head-open" data-inactive-class="crm-start-graph-head-inactive">
<div class="crm-start-graph-title">
<div class="crm-start-graph-title-avatar" data-role="user-photo" style="background-image:url(';
                    echo $value1['avatar'];
                    echo ')"></div>
<div class="crm-start-graph-title-user">
<span class="crm-start-graph-title-link" data-role="user-name">';
                    echo $value1['name'];
                    echo '</span>
<span class="crm-start-graph-title-position" data-role="user-title"></span>
</div>
</div>
<div class="crm-start-graph-wrapper">
<div class="crm-start-graph-progress" data-role="user-progress" data-more-class="crm-start-graph-progress-more">
<div class="crm-start-graph-progress-line" style="width: ';
                    echo strval($value1['marginPercent']) . '%;"; data-role="user-progress-line"></div>
<div class="crm-start-graph-progress-total" data-role="user-progress-line-value">';
                    echo strval(round($value1['marginPercent']));
                    echo '<span></span></div>
</div>
<div class="crm-start-graph-total-sum" data-role="user-target">';
                    echo strval(round($value1['plannedMargin']));
                }

                echo ' <span> тенге</span></div>
</div>
</div>
<div class="crm-start-graph-content" data-role="user-target-details" data-open-class="crm-start-graph-content-open">
<div class="crm-start-graph-user-plan">
<div class="crm-start-graph-user-plan-item">
<span class="crm-start-graph-user-plan-title">Выполнено</span>
<div class="crm-start-graph-user-plan-total" data-role="user-target-current">';
                echo $value1['marginMade'];
                echo '<span> тенге</span></div>
</div>
<div class="crm-start-graph-user-plan-item">
<span class="crm-start-graph-user-plan-title">Осталось</span>
<div class="crm-start-graph-user-plan-total" data-role="user-target-remaining">';
                if ($value1['plannedMargin'] - $value1['marginMade'] > 0) {
                    echo $value1['plannedMargin'] - $value1['marginMade'];
                } else {
                    echo "0";
                }
                echo '<span> тенге</span></div>
</div>
<div class="crm-start-graph-user-plan-item">
<span class="crm-start-graph-user-plan-title">Выполнение плана</span>
<div class="crm-start-graph-user-plan-total">
<span class="crm-start-graph-user-plan-sum" data-role="user-target-effective">';
                echo strval(round($value1['marginPercent']));
                echo '</span>
<span class="crm-start-graph-user-plan-symbol">%</span>
</div>
</div>
</div>
</div>
</div>';
            }
        } else {
            echo "<h1>";
            echo '<pre>';
            print_r($fromListUsersId[$key]);
            echo '</pre>';
            echo '</h1>';

            echo '<h1>';
            echo count($fromListUsersId[$key]);
            echo '</h1>';

        }
        echo '</div>
    <div class="crm-start-saletarget-general-progress"
        data-include="widget-saletarget-general-progress">
        <div>
            <div
                class="crm-start-row crm-start-row-flex">

                <div class="crm-start-graph-title"
                    data-if="view-type=USER">
                    <span
                        class="crm-start-graph-title-text">Выполнение
                        плана
                        сотрудниками</span>
                </div>
                <div
                    class="crm-start-graph-wrapper">
                    <div class="crm-start-graph-month-progress"
                        data-role="progress"
                        data-more-class="crm-start-graph-progress-more">';
        if (($sumOfMargin[$value] / $sumOfPlan[$value]) * 100 > 100) {
            echo '<div class="crm-start-graph-month-progress-line"
                            style="width: 100%;"
                            data-role="progress-line">
                            </div>
                            <div class="crm-start-graph-progress-total"
                            style="position: absolute; z-index: 1000; right: 0;"
                            data-role="progress-total">';
            echo round(($sumOfMargin[$value] / $sumOfPlan[$value]) * 100);
            echo '</div>';
        } else {
            echo '<div class="crm-start-graph-month-progress-line"
                            style="width:' . ($sumOfMargin[$value] / $sumOfPlan[$value]) * 100 . '%;"
                            data-role="progress-line">
                            </div>
                            <div class="crm-start-graph-progress-total"
                            data-role="progress-total">';
            echo round(($sumOfMargin[$value] / $sumOfPlan[$value]) * 100);
            echo '</div>';
        }
        echo '</div>
    <div
        class="crm-start-graph-month-scale crm-start-graph-month-scale-28">
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div
            class="crm-start-graph-month-scale-item">
        </div>
        <div class="crm-start-graph-month-scale-item-first"
            data-role="first-day">';
        if ($value == 'I') {
            echo '1 января';
        } else if ($value == 'II') {
            echo '1 апреля';
        } else if ($value == 'III') {
            echo '1 июля';
        } else if ($value == 'IV') {
            echo '1 октября';
        }
        echo '</div>
    <div
        class="crm-start-graph-month-scale-item-middle">
    </div>
    <div class="crm-start-graph-month-scale-item-last"
        data-role="last-day">';
        if ($value == 'I') {
            echo '31 марта';
        } else if ($value == 'II') {
            echo '30 июня';
        } else if ($value == 'III') {
            echo '30 сентября';
        } else if ($value == 'IV') {
            echo '31 декабря';
        }
        echo '</div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="crm-start-row">
<div class="crm-start-row-result">
<div
class="crm-start-row-result-item">
<div
class="crm-start-row-result-item-title">
Выполнено</div>
<div class="crm-start-row-result-item-total"
data-role="total-complete">';
        echo $sumOfMargin[$value];
        echo '<span>
тенге</span></div>
</div>
<div
class="crm-start-row-result-item">
<div
class="crm-start-row-result-item-title">
Осталось</div>
<div class="crm-start-row-result-item-total"
data-role="total-remaining">';
        if ($sumOfPlan[$value] - $sumOfMargin[$value] < 0) {
            echo '0';
        } else {
            echo $sumOfPlan[$value] - $sumOfMargin[$value];
        }
        echo '<span>
    тенге</span></div>
</div>
<div
class="crm-start-row-result-item">
<div
class="crm-start-row-result-item-title">
Выполнение плана</div>
<div
class="crm-start-row-result-item-total">
<span
    class="crm-start-row-result-item-total-sum"
    data-role="total-progress-percent">';
        echo round(($sumOfMargin[$value] / $sumOfPlan[$value]) * 100);
        echo '</span>
    <span>%</span>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="report-visualconstructor-dashboard-row-move-control">^</div>
<div class="report-visualconstructor-dashboard-row-add-control">+</div>
</div>
</div>
</div>
<div class="report-visualconstructor-demo-flag">
<div class="report-visualconstructor-demo-flag-text">Это демо-представление, вы можете
скрыть его и получить аналитику по вашим данным.</div>
<div class="report-visualconstructor-demo-flag-close-button"></div>
<div class="report-visualconstructor-demo-flag-hide-link">Скрыть демо-представление
</div>
</div>
</div>
</div>
</div>

</div>
</div>
<div class="popup-window popup-window-with-titlebar popup-window-fixed-width" id="crm-start-config"
style="display: none; position: absolute; left: 594.5px; top: ';
        if ($value == 'I') {
            echo '75px;';
        } else if ($value == 'II') {
            echo '130px;';
        } else if ($value == 'III') {
            echo '185px;';
        } else if ($value == 'IV') {
            echo '240px;';
        }
        echo 'z-index: 1050 !important; width: 530px;">
<div class="popup-window-titlebar" id="popup-window-titlebar-crm-start-config" style="cursor: move;"><span
class="popup-window-titlebar-text">План продаж</span></div>
<div id="popup-window-content-crm-start-config" class="popup-window-content" style="overflow-x: auto;">
<div style="display: block;">
<form data-role="form">
<div class="crm-start-popup-row crm-start-popup-row-border">
<div class="crm-start-popup-row-title">
<span class="crm-start-popup-text">Выберите период на выполнение плана:</span>
</div>
<div class="crm-start-popup-row-content">
<table>
<tbody>
<tr>
<td><span class="crm-start-popup-link" data-role="period-type">Квартал</span>
</td>
<td>
<div class="crm-start-dropdown" data-role="period-month"
style="display: none;">
<span class="crm-start-dropdown-text"
data-role="period-month-value">Март</span>
</div>
<div class="crm-start-dropdown" data-role="period-quarter">
<span class="crm-start-dropdown-text"
data-role="period-quarter-value">';
        echo $value;
        echo '</span>
</div>
<div class="crm-start-dropdown" data-role="period-half"
style="display: none;">
<span class="crm-start-dropdown-text"
data-role="period-half-value">I</span>
</div>
</td>
<td>
<div class="crm-start-dropdown" data-role="period-year">
<span class="crm-start-dropdown-text"
data-role="period-year-value">2023</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="crm-start-popup-row crm-start-popup-row-border">
<div class="crm-start-popup-row-title">
<span class="crm-start-popup-text">Укажите цель для плана продаж:</span>
</div>
<div class="crm-start-popup-row-content">
<div class="crm-start-dropdown" data-role="target-type">
<span class="crm-start-dropdown-text" data-role="target-type-value">Сумма маржи</span>
</div>
</div>
</div>
<div class="crm-start-popup-row crm-start-popup-row-border crm-start-popup-row-margin-bottom">
<div class="crm-start-popup-row-title">
<span class="crm-start-popup-text">Вид плана:</span>
</div>
<div class="crm-start-popup-row-content">
<div class="crm-start-dropdown" data-role="view-type">
<span class="crm-start-dropdown-text" data-role="view-type-value">По людям</span>
</div>
</div>
</div>
<div data-role="view-type-content">
<div>
<div data-loop="users" class="crm-start-popup-users">

</div>
<div class="crm-start-popup-row crm-start-popup-row-border">
<span class="crm-start-popup-link crm-start-popup-link-plus"
data-role="user-add">добавить еще</span>
</div>
</div>
</div>
<div class="crm-start-popup-row crm-start-popup-row-block">
<a target="_blank" href="/crm/configs/deal_category/" class="crm-start-popup-config"
data-role="categories-link" style="display: none">Настроить направления</a>
<span class="crm-start-popup-copy" data-role="copy-configuration"></span>
</div>
</form>
</div>
</div><span class="popup-window-close-icon popup-window-titlebar-close-icon"></span>
<div class="popup-window-buttons"><span class="webform-small-button webform-small-button-accept"
id="">Сохранить</span><span
class="popup-window-button popup-window-button-link popup-window-button-link-cancel"
id="">Отменить</span></div>
</div>
<div class="popup-window" id="menu-popup-saletarget-selector-0.8779927661035722"
style="display: none; position: absolute; left: 789.5px; top: 268px; z-index: 1150 !important; padding: 0px;">
<div id="popup-window-content-menu-popup-saletarget-selector-0.8779927661035722" class="popup-window-content"
style="padding: 0px;">
<div class="menu-popup" style="display: block;">
<div class="menu-popup-items"><span class="menu-popup-item menu-popup-no-icon "><span
class="menu-popup-item-icon"></span><span class="menu-popup-item-text">По
людям</span></span><span class="menu-popup-item menu-popup-no-icon "><span
class="menu-popup-item-icon"></span><span class="menu-popup-item-text">По
направлениям</span></span><span class="menu-popup-item menu-popup-no-icon "><span
class="menu-popup-item-icon"></span><span class="menu-popup-item-text">На всю
компанию</span></span></div>
</div>
</div>
<div class="popup-window-angly popup-window-angly-top" style="left: 23px; margin-left: 0px;">
<div class="popup-window-angly--arrow"></div>
</div>
</div>
<div class="popup-window bx-finder-popup bx-finder-v2" id="BXSocNetLogDestinationContainer"
style="display: none; position: absolute; left: 621px; top: 339px; z-index: 1100 !important;">
<div id="popup-window-content-BXSocNetLogDestinationContainer" class="popup-window-content">
<div>
<div class="bx-finder-box bx-finder-box-vertical bx-lm-box bx-lm-socnet-log-destination"
style="min-width: 650px; padding-bottom: 8px; overflow: hidden;">
<div class="bx-finder-search-block">
<div class="bx-finder-search-block-cell"><span id="bx-dest-internal-item"></span><span
id="bx-dest-internal-input-box" style="display: inline-block"
class="feed-add-destination-input-box"><input type="text" id="bx-dest-internal-input"
class="feed-add-destination-inp"></span></div>
</div>
<div id="BXSocNetLogDestinationContainerContent" class="bx-finder-container-content">
<div class="bx-finder-box bx-finder-box-vertical bx-lm-box bx-lm-socnet-log-destination"
style="min-width: 650px; padding-bottom: 8px;">
<div class="bx-finder-box-tabs"><a hidefocus="true"
id="destLastTab_saletarget-user-selector-fo5n20o" href="#switchTab"
class="bx-finder-box-tab bx-lm-tab-last bx-finder-box-tab-selected">Последние</a><a
hidefocus="true" id="destDepartmentTab_saletarget-user-selector-fo5n20o"
href="#switchTab" class="bx-finder-box-tab bx-lm-tab-department">Сотрудники и
отделы</a><a hidefocus="true" id="destSearchTab_saletarget-user-selector-fo5n20o"
href="#switchTab" class="bx-finder-box-tab bx-lm-tab-search">Поиск</a>
<div class="popup-window-hr popup-window-buttons-hr"><i></i></div>
</div>
<div id="bx-lm-box-last-content"
class="bx-finder-box-tabs-content bx-finder-box-tabs-content-window">
<table class="bx-finder-box-tabs-content-table">
<tr>
<td class="bx-finder-box-tabs-content-cell">
<div
class="bx-finder-box-tab-content bx-lm-box-tab-content-last bx-finder-box-tab-content-selected">
<span class="bx-finder-groupbox false">
<span class="bx-finder-groupbox-name">Люди:</span>
<span class="bx-finder-groupbox-content">';
        foreach ($result1->result as $key1 => $value1) {
            echo '<a id="saletarget-user-selector-fo5n20o_last_U36"
        hidefocus="true"
        rel="U36"
        class="bx-finder-box-item-t7 bx-finder-element bx-lm-element-user"
        href="#U36"
        aqua_id="' . $value1->ID . '">
        <div class="bx-finder-box-item-t7-avatar">
            <img bx-lm-item-id="U36" bx-lm-item-type="users"
                class="bx-finder-box-item-t7-avatar-img"
                src="';
            if (isset($value1->PERSONAL_PHOTO)) {
                echo $value1->PERSONAL_PHOTO;
            } else {
                echo 'data:image/svg+xml;charset=US-ASCII,%3Csvg%20viewBox%3D%220%200%2089%2089%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Ccircle%20fill%3D%22%23535C69%22%20cx%3D%2244.5%22%20cy%3D%2244.5%22%20r%3D%2244.5%22/%3E%3Cpath%20d%3D%22M68.18%2071.062c0-3.217-3.61-16.826-3.61-16.826%200-1.99-2.6-4.26-7.72-5.585-1.734-.483-3.383-1.233-4.887-2.223-.33-.188-.28-1.925-.28-1.925l-1.648-.25c0-.142-.14-2.225-.14-2.225%201.972-.663%201.77-4.574%201.77-4.574%201.252.695%202.068-2.4%202.068-2.4%201.482-4.3-.738-4.04-.738-4.04.388-2.625.388-5.293%200-7.918-.987-8.708-15.847-6.344-14.085-3.5-4.343-.8-3.352%209.082-3.352%209.082l.942%202.56c-1.85%201.2-.564%202.65-.5%204.32.09%202.466%201.6%201.955%201.6%201.955.093%204.07%202.1%204.6%202.1%204.6.377%202.556.142%202.12.142%202.12l-1.786.217c.024.58-.023%201.162-.14%201.732-2.1.936-2.553%201.485-4.64%202.4-4.032%201.767-8.414%204.065-9.193%207.16-.78%203.093-3.095%2015.32-3.095%2015.32H68.18z%22%20fill%3D%22%23FFF%22/%3E%3C/svg%3E';
            }
            echo '">
            <span class="bx-finder-box-item-avatar-status"></span>
        </div>
        <div class="bx-finder-box-item-t7-space"></div>
        <div class="bx-finder-box-item-t7-info">
            <div class="bx-finder-box-item-t7-name">';
            echo $value1->NAME . ' ' . $value1->LAST_NAME;
            echo '</div></div></a>';
        }
        echo '</span>
    </span>
</div>
<div class="bx-finder-box-tab-content bx-lm-box-tab-content-department">';
        foreach ($departments as $key1 => $value1) {
            echo '<div class="bx-finder-company-department" department_id="';

            echo $key1;
            echo '">
    <a href="#DR26" class="bx-finder-company-department-inner" hidefocus="true">
        <div class="bx-finder-company-department-arrow"></div>
        <div class="bx-finder-company-department-text">';
            echo $value1['NAME'];
            echo '</div>
    </a>
</div>
<div class="bx-finder-company-department-children">';

            echo '<div class="bx-finder-company-department-employees" id="bx-lm-category-relation-26">';
            foreach ($value1['EMPLOYEES'] as $key2 => $value2) {
                echo '<a href="#U22" class="bx-finder-company-department-employee  bx-finder-element" rel="U22" hidefocus="true" aqua_id="';
                echo $key2;
                echo '">
<div class="bx-finder-company-department-employee-info">
    <div class="bx-finder-company-department-employee-name">';
                echo $value2['NAME'];
                echo '</div>
    <div class="bx-finder-company-department-employee-position"></div>
</div>
<div style="background:url(' . $value2['AVATAR'] . ') no-repeat center center; background-size: cover;" class="bx-finder-company-department-employee-avatar"></div>
</a>';
            }

            echo '</div></div>';
        }
        echo '</div>

    <div id="destSearchTabContent_saletarget-user-selector-fo5n20o"
        class="bx-finder-box-tab-content bx-lm-box-tab-content-search"></div>
</td>
</tr>
</table>
</div>
<div id="bx-lm-box-search-waiter" class="bx-finder-box-search-waiter" style="height: 0px;">
<img src="https://aquakip.bitrix24.ru/bitrix/js/main/core/images/waiter-white.gif"
class="bx-finder-box-search-waiter-background">
<div class="bx-finder-box-search-waiter-text">Идет поиск дополнительных результатов...
</div>
</div>
</div>
</div>
</div>
</div>
</div><span class="popup-window-close-icon"></span>
<div class="popup-window-angly popup-window-angly-bottom" style="left: 0px; margin-left: 23px;">
<div class="popup-window-angly--arrow"></div>
</div>
</div>
<div class="popup-window" id="menu-popup-saletarget-selector-0.4124669995415431" style="display: none; position: absolute; left: 876.141px; top: 119px; z-index: 1100 !important; padding: 0px;">
<div id="popup-window-content-menu-popup-saletarget-selector-0.4124669995415431" class="popup-window-content" style="padding: 0px;">
<div class="menu-popup" style="display: block;">
<div class="menu-popup-items"><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">I квартал</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">II квартал</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">III квартал</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">IV квартал</span></span></div>
</div>
</div>
<div class="popup-window-angly popup-window-angly-top" style="left: 23px; margin-left: 0px;">
<div class="popup-window-angly--arrow"></div>
</div>
</div>



<div class="popup-window" id="menu-popup-saletarget-selector-0.5182406928841863" style="display: none; position: absolute; left: 939.062px; top: 119px; z-index: 1150 !important; padding: 0px;">
<div id="popup-window-content-menu-popup-saletarget-selector-0.5182406928841863" class="popup-window-content" style="padding: 0px;">
<div class="menu-popup" style="display: block;">
<div class="menu-popup-items"><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2017</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2018</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2019</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2020</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2021</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2022</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2023</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2024</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2025</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2026</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2027</span></span><span class="menu-popup-item menu-popup-no-icon "><span class="menu-popup-item-icon"></span><span class="menu-popup-item-text">2028</span></span></div>
</div>
</div>
<div class="popup-window-angly popup-window-angly-top" style="left: 23px; margin-left: 0px;">
<div class="popup-window-angly--arrow"></div>
</div>
</div>
</div>';
    }
    ?>
    <script>
        function showDiv(element) {
            console.log("OK")
            if (element.children[1].classList.contains('crm-start-graph-content-open')) {
                console.log(element.children[1].classList.contains('crm-start-graph-content-open'))
                element.children[1].classList.remove('crm-start-graph-content-open');
            }
            else {
                console.log(element.children[1].classList.contains('crm-start-graph-content-open'))
                element.children[1].classList.add('crm-start-graph-content-open');
            }
        }
    </script>
    <script src="script.js"></script>
</body>

</html>
