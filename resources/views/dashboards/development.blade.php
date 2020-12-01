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
        <twitter position="a1:a16" :initial-tweets="{{ json_encode($initialTweets) }}"></twitter>
        <statistics position="a17:a24"></statistics>
        <dev-services position="a1:a24"></dev-services>
        <time-weather position="f1:f6" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
        <internet-connection position="f1:f6"></internet-connection>
        <gitlab-labels position="b1:c16" label="Planned" :show-time="false" :show-assignees="true" order-by="weight"></gitlab-labels>
        <gitlab-labels position="b17:c24" label="Bug patrol" :show-time="false" :show-assignees="true" order-by="weight"></gitlab-labels>
        <gitlab-labels position="d1:e16" label="In progress" :show-time="false" order-by="weight" :show-assignees="true"></gitlab-labels>
        <gitlab-milestones position="d17:e24"></gitlab-milestones>
        <stats position="f7:f16"></stats>
        <pods position="f17:f24"></pods>
    </dashboard>
</div>

@endsection
