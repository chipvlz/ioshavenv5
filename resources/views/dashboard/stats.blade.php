@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 m-auto">
            <div class="card">
                <div class="card-header">Stats</div>

                <div class="card-body p-0">
                    <chart :routes="['/stats/downloads', '/stats/likes/apps', '/stats/views/apps']"></chart>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="/js/plotly.js"></script>
@endsection
