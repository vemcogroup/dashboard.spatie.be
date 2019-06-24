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
        <twitter position="a1:a21" :initial-tweets="{{ json_encode($initialTweets) }}"></twitter>
        <dev-services position="a1:a21"></dev-services>
        <time-weather position="f1:f6" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
        <internet-connection position="f1:f6"></internet-connection>
        <gitlab-labels position="b1:c21" label="To Do" :show-time="false" :show-assignees="true" order-by="weight"></gitlab-labels>
        <gitlab-labels position="d1:e21" label="Implementing solution" :show-time="false" order-by="weight" :show-assignees="true"></gitlab-labels>
        <stats position="f7:f17"></stats>
        <statistics position="f18:f24"></statistics>
        <rss-feed position="a22:e24"></rss-feed>
    </dashboard>
</div>

@endsection