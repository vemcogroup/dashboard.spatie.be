@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="6" rows="3">
    <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a3"></twitter>
    <gitlab-labels label="To Do" :show-time="false" :show-assignees="false" position="b1:c3"></gitlab-labels>
    <gitlab-labels label="Implementing solution" :show-time="true" order-by="weight" :show-assignees="true" position="d1:e3"></gitlab-labels>
    <time-weather position="f1" date-format="ddd DD/MM" time-zone="Europe/Copenhagen" weather-city="Fredericia"></time-weather>
    <api-status position="f2"></api-status>
    <gitlab-totals position="f3"></gitlab-totals>
    <internet-connection></internet-connection>
</dashboard>

@endsection
