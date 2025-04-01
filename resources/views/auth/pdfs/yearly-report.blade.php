<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Yearly Report</title>
        {{-- style --}}
        <style>
            html{
                font-size: 14px;
            }
            *, *::after, *::before{
                box-sizing: border-box;
                padding: 0;
                margin: 0;
                font-family: sans-serif;
            }
            .header-pdf{
                display: flex;
                flex-direction: column;
                justify-content: center;
                margin-bottom: 16px;
            }

            .text-header-container{
                text-align: center;
            }

            .header-pdf > div {
                /* border: 1px solid red; */
                display: flex;
                flex-direction: column;
                gap: 1em;
                align-items: center;
            }
            .header-pdf > div > span{
                /* border: 1px solid blue; */
            }

            table{
                border-collapse: collapse;
            }

            table thead th {
                border: 1px solid black;
                padding: 7px;
            }

            table td {
                border: 1px solid black;
                text-align: center;
                padding: 7px;
            }

            @page {
                margin: 32px !important;
            }
        </style>
    </head>
    <body>
        <main>
            {{-- header --}}
            <div class="header-pdf">
                <div class="text-header-container" style="margin-bottom: 16px;">
                    <span>Republic of the Philippines</span><br>
                    <span style="font-weight: bold;">PROVINCE OF SOUTHERN LEYTE</span><br>
                    <span>Municipality of Sogod</span><br>
                </div>
                <div class="text-header-container" style="margin-bottom: 16px;">
                    <span style="font-size: 16px !important; font-weight: bold;">MUNICIPAL DISASTER RISK REDUCTION AND MANAGEMENT OFFICE</span>
                </div>
                <div class="text-header-container"style="font-weight: bold;">
                    <span>SUMMARY OF INCIDENT/EMERGENCY REPORT</span><br>
                    <span>FROM JANRUARY - DECEMBER {{$year}}</span>
                </div>
            </div>

            {{-- table --}}
            <table>
                <thead>
                    <tr>
                        <th rowspan="3">No.</th>
                        <th rowspan="3">Month</th>
                        <th rowspan="3">Incident/Emergency</th>
                        <th rowspan="3">Date & Time Incident(YYYY-MM-DD H:m)</th>
                        <th rowspan="3">Location Of Incident</th>
                        <th rowspan="3">Incident Type</th>
                        <th colspan="3">Details Of Incident</th>
                        <th rowspan="3">Responded by (Agency)</th>
                        <th rowspan="3">Refer to Hospital</th>
                        <th rowspan="3">Remarks</th>
                    </tr>
                    <tr>
                        <th colspan="2">Involved</th>
                        <th rowspan="2">Immediate Cause or Reason</th>
                    </tr>
                    <tr>
                        <th>M</th>
                        <th>F</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- LOOP THE responses data --}}
                    @foreach ($responses as $response)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $response->date_time->format('F')}}</td>
                            <td>{{ $response->incident_type}}</td>
                            <td class="text-nowrap">{{ $response->date_time->format('Y-m-j | h:i A')}}</td>
                            <td>{{ $response->location}}</td>
                            <td>{{ $response->incident_type }}</td>
                            @if ($response->involve == 'mf')
                                <td>
                                    M
                                </td>
                                <td>
                                    F
                                </td>
                            @endif

                            @if ($response->involve == 'm')
                                <td>
                                    M
                                </td>
                                <td>

                                </td>
                            @endif

                            @if ($response->involve == 'f')
                                <td>
                                    F
                                </td>
                                <td>

                                </td>
                            @endif
                            <td>{{ $response->immediate_cause_or_reason }}</td>
                            <td>
                                {{$response->respondents_name}}
                            </td>
                            <td>{{ $response->refered_hospital }}</td>
                            <td>{{ $response->remark }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>