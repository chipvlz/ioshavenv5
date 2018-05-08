@extends('layouts.app')

@section('content')
<?php
App\Report::warning([
  "message" => "invalid permissions",
  "data" => [
    "error" => App\Report::e($exception)
  ],
  "scope" => 'resources/views/errors/403.blade.php',
]);
?>
<h1>Invalid permissions.</h1>
@endsection
