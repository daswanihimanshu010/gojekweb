@extends('common.provider.layout.base')
@section('styles')
@parent
@stop
@section('content')
<!-- Schedule Ride Modal -->
<div id="toaster" class="toaster"></div>
<section style="min-height: 100vh;" class="taxi-banner z-1 content-box" id="booking-form">
      <div id="root"></div>
</section>
@stop
@section('scripts')
@parent
window.salt_key = '{{ Helper::getSaltKey() }}';
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>

<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script type="text/babel" src="{{ asset('assets/layout/js/transport/incoming.js') }}"></script>
@stop
