<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href=" {{ asset('assets') }}/css/slider.css">
    <link rel="stylesheet" type="text/css" href=" {{ asset('assets') }}/dropify/dist/css/dropify.min.css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
 
<!-- Alpine Core -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<style>
    .bg-costume {
      background-color: #00B7B5;
    }


    .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
      background-color: #00B7B5;
    }

    p {
      /* font-weight: bold; */
      color: #FFFFFF;
    }

    .majoo{
      color: #FFFFFF;
    }

    
    .nav-link:hover {
        background-color: #00B7B5;
    }
  

    body {
      color: #787878;
    }

    .page-item.active .page-link {
      z-index: 3;
      color: #fff;
      background-color: #00B7B5;
      border-color: #00B7B5;
    }

    .page-link {
      position: relative;
      display: block;
      padding: .5rem .75rem;
      margin-left: -1px;
      line-height: 1.25;
      color: #F7BD9C;
      background-color: #fff;
      border: 1px solid #dee2e6;
    }

    .start-date .end-date {
      background-color: #00B7B5;
    }

    .btn-costume {
      background-color: #00B7B5;
      color: white;
    }

    .btn-costume:hover{
      color: white;
    }

    .btn-peace {
      background-color: #00B7B5;
      color: white;
    }

    [class*=sidebar-dark] .brand-link {
      border-bottom: 1px solid #00B7B5;
      color: rgba(255, 255, 255, .8);
    }


  </style>
  <style>
    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th {
      background-color: #00B7B5;
      text-decoration-color: white;
      color: white;
      cursor: pointer;
    }
  </style>
