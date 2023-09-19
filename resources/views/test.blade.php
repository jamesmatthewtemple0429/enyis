@extends('layouts.report')
    @section('team','Test')
    @section('name',$report->name)

@section('content')
        @foreach($report->sections as $section)
            @if($section->type != 3)
                <div style="margin-bottom: 25px;">
            @else
                <div>
            @endif
                @if($section->type != 3 && $section->type != 7)<div style="color: darkred; font-size:14px; margin-bottom: 20px;"><strong>{{ $section->name }}</strong></div>@endif

                @if($section->type == 1)
                    <blockquote style="margin-left: 5px;">{{ $section->value }}</blockquote>
                @endif

                @if($section->type == 2)
                    <span style="margin-left: 5px;">{{ $section->value }}</span>
                @endif

                @if($section->type == 3)

                @foreach($sectionData[$section->id] as $chunk)
                        @foreach($chunk as $alert)
                            <div style="margin-bottom: 25px;">
                                <div style="font-size: 13px;"><strong>{{ $alert->event  }} issued by {{ $alert->sender }}</strong></div>


                                <blockquote style="font-size:12px; margin-bottom: 20px;">Area(s) Affected: {{ $alert->zones }}</blockquote>
                                <blockquote style="font-size:12px;">Effective: {{ $alert->effective_at->format('M d, Y h:i A') }}</blockquote>
                                <blockquote style="font-size:12px;">Expires: {{ $alert->expires_at->format('M d, Y h:i A') }}</blockquote>

                                <blockquote style="font-size: 12px;"><em>{!! str_replace('*','<br />*',$alert->description) !!}</em></blockquote>
                                <blockquote>{{ $alert->instructions }}</blockquote>

                            </div>
                        @endforeach
                        <div style="page-break-after: always;"></div>
                    @endforeach
                @endif

                @if($section->type == 4)
                    <span style="margin-left: 5px;">{{ $section->value }}</span>

                    @foreach($sectionData[$section->id] as $county => $forecasts)
                    <div style="margin-bottom: 20px; font-size:14px;">{{ $county }} County</div>
                    <table>
                        <thead>
                            <tr>
                                <th width="25%" style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">Area</th>
                                <th width="25%" style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">Time Period</th>
                                <th width="50%" style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">Forecast</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forecasts as $forecast)
                            <tr>
                                <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">
                                    {{ $forecast['wx_zone']['name'] }}</td>
                                <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">
                                    {{ $forecast['name'] }}</td>
                                <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">
                                    {{ $forecast['description'] }}</td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                        <div style="page-break-after: always;"></div>

                    @endforeach
                @endif

                @if($section->type == 5)
                    <table style="width: 100%;">
                        <thead>
                            <tr style="border: 1px solid black;">
                                <th style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">Position</th>
                                <th style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">Member Name</th>
                                <th style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">Cell Phone</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($section->roles as $role)
                                @foreach(getRoleMembers($role) as $member)<tr>
                                    <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">
                                        <div>{{ trim(preg_replace("/\([^)]+\)/","",$role->position)) }}</div>
                                        @if(maybe($member, getRoleInterim($role))['is_interim'] == true)
                                            <div style="text-align:center; margin-top: 10px; font-size:10px; margin-left:5px; color:red; float:right;"><strong>Interim until {{ maybe($member, getRoleInterim($role))['interim_until'] }}</strong></div>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">{{ maybe($member, getRoleInterim($role))['name'] }}</td>
                                    <td style="padding: 10px; text-align:center; padding: 10px; font-size:11px; border: 1px solid black;">{{ maybe($member, getRoleInterim($role))['cell_phone'] }}</td>
                                </tr>
                                @endforeach
                        @endforeach
                        </tbody>
                    </table>
                @endif

                @if($section->type == 6)
                    <span style="margin-left: 5px;">{{ $section->value }}</span>

                    <table width="100%">
                        <thead>
                            <tr>
                                @foreach($section->fields as $field)
                                <th style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">{{ $field['display'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($sectionData[$section->id]))
                                @foreach($sectionData[$section->id] as $item)
                                    <tr>
                                        @foreach($section->fields as $field)
                                            <td style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">{{ $item[$field['key']] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100%" style="padding: 10px; text-align:center; font-size:11px; border: 1px solid black;">There are no
                                        {{ $section->name }} yet.</td>
                                </tr>
                           @endif
                        </tbody>
                    </table>
                @endif

                    @if($section->type == 7)
                        <div style="page-break-after: always;"></div>
                    @endif
                </div>

        @endforeach
    </body>
</html>@endsection
