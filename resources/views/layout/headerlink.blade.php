<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php  echo url('/') ?>/resources/sass/favicon_my_cycle/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php  echo url('/') ?>/resources/sass/favicon_my_cycle/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php  echo url('/') ?>/resources/sass/favicon_my_cycle/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <title>My Cycle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    {{-- Bootstrap core CSS   --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/bootstrap/css/bootstrap.min.css') }}" />



    {{-- Font Awesome   --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/font-awesome.min.css',true) }}" />


    {{-- Pace  --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/pace.css',true) }}" />

    {{-- Color box  --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/colorbox/colorbox.css',true) }}" />

    {{-- Morris  --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/morris.css',true) }}" />


    {{-- Endless  --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/endless.min.css',true) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/endless-skin.css',true) }}" />

    <!-- datatable CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('/resources/sass/datatable/css/jquery.dataTables.css',true) }}" />

    <!-- datepicker -->
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('/resources/sass/datepicker/bootstrap-datepicker3.min.css',true) }}" />

    <!-- Searchable Select -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/select2/select2.min.css',true) }}" />

    <!-- toggle button -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/css/bootstrap-toggle.min.css',true) }}" />

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/resources/sass/sweetalert/sweetalert.css',true) }}" />

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="{{ URL::asset('/resources/sass/css/bootstrap-datetimepicker.css',true) }}">

  {{--  tost msg  --}}
  <link href="{{ URL::asset('/resources/sass/toastr/toastr.min.css',true) }}" rel="stylesheet">

</head>
