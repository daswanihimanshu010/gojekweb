@extends('common.provider.layout.base')
@section('styles')
@parent
@stop
@section('content')
<!-- Schedule Ride Modal -->
<section class="taxi-banner z-1 content-box" id="booking-form">
      <div id="root"></div>
</section>
@stop
@section('scripts')
@parent
window.salt_key = '{{ Helper::getSaltKey() }}';
<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script type="text/babel" src="{{ asset('assets/layout/js/service/incoming.js') }}"></script>
@stop
