@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="6" rows="8">
    <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a7"></twitter>
    <gitlab-labels label="To Do" :show-time="false" :show-assignees="false" order-by="weight" position="b1:c7"></gitlab-labels>
    <gitlab-labels label="Implementing solution" :show-time="true" order-by="weight" :show-assignees="true" position="d1:e7"></gitlab-labels>
    <time-weather position="f1:f2" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
    <stats position="f3:f8"></stats>
    <rss-feed position="a8:e8"></rss-feed>
    <internet-connection></internet-connection>
</dashboard>

@endsection
