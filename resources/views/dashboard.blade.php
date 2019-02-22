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
        <time-weather position="f1:f6" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
        <internet-connection position="f1:f6"></internet-connection>
        <gitlab-labels position="b1:c21" label="To Do" :show-time="false" :show-assignees="true" order-by="weight"></gitlab-labels>
        <gitlab-labels position="d1:e15" label="Implementing solution" :show-time="true" order-by="weight" :show-assignees="true"></gitlab-labels>
        <gitlab-milestones position="d16:e21"></gitlab-milestones>
        <stats position="f7:f16"></stats>
        <statistics position="f17:f24"></statistics>
        <rss-feed position="a22:e24"></rss-feed>
    </dashboard>
</div>

@endsection
