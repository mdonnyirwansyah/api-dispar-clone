@extends('layouts.app')

@push('stylesheet')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.css"/>
@endpush

@push('javascript')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.js"></script>
  {!! $dataTable->scripts() !!}
  @include('app.news.posts.delete')
@endpush

@section('content')
  <section class="section">
    <div class="section-header">
      <h1><span class="text-capitalize">{{ $title }}</span></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">News</a></div>
        <div class="breadcrumb-item"><span class="text-capitalize">{{ $title }}</span></div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">List of <span class="text-capitalize">{{ $title }}</span></h2>
      <p class="section-lead">This page is for managing <span class="text-lowercase">{{ $title }}</span>.</p>
      <div class="card">
        <div class="card-body">
          <div class="col-12">
            <div class="section-header-button mb-3">
              <a href="{{ route('news.posts.create') }}" class="btn btn-primary" onClick="createRecord()">Add New</a>
            </div>
            <hr>
            {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap', 'cellpadding' => '0', 'style' => 'width: 100%']) !!}
          </div>
        </div>
      </div>
    </div>
  </section>

  <div id="view-modal" style="display: none"></div>
  
@endsection
