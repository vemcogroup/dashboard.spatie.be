@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="5" rows="3">
    <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a3"></twitter>
    <uptime position="a1:a3"></uptime>
    <packagist position="b1"></packagist>
    <npm position="b2"></npm>
    <gitlab position="b3"></gitlab>
    <music position="d1"></music>
    <tasks team-member="dkralj" position="c1:c3"></tasks>
    <tasks team-member="makije" position="d1:d3"></tasks>
    <time-weather position="e1" date-format="ddd DD/MM" time-zone="Europe/Brussels" weather-city="Fredericia"></time-weather>
    <api-status position="e2:e3"></api-status>
    <internet-connection></internet-connection>
</dashboard>

@endsection
