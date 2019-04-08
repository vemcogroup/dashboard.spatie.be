@extends('layouts/master')

@section('content')

    @javascript(
        compact(
            'socketAppKey', 'socketCluster', 'socketHost', 'socketPort', 'socketSecurePort',
            'socketDisableStats', 'socketEncrypted',
            'environment', 'openWeatherMapKey'
    ))

<div id="dashboard">
    <dashboard class="font-sans">
        <time-weather position="g1:h6" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
        <internet-connection position="g1:h6"></internet-connection>
        <services position="g7:h22"></services>
        <helpdesk-tickets position="a1:c22"></helpdesk-tickets>
        <sensors-offline position="d1:f22"></sensors-offline>
    </dashboard>
</div>

@endsection
