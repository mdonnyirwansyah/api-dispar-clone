@extends('layouts.app')

@push('javascript')
  {!! $dataTable->scripts() !!}
  @include('app.news.categories.partials.crud')
@endpush

@section('content')
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="features-posts.html" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>List of <span class="text-capitalize">{{ $title }}</span></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">News</a></div>
        <div class="breadcrumb-item">List of <span class="text-capitalize">{{ $title }}</span></div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">List of <span class="text-capitalize">{{ $title }}</span></h2>
      <p class="section-lead">This page is for managing <span class="text-lowercase">{{ $title }}</span>.</p>
      <div class="card">
        <div class="card-body">
          <div class="col-12">
            <div class="section-header-button mb-3">
              <button class="btn btn-primary" onClick="createRecord()">Add New</button>
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
