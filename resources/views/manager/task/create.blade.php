@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manager.task.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autocomplete="off">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Description') }}
                                </label>

                                <div class="col-md-6">
                                    <textarea id="description"
                                              class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                              name="description" autocomplete="off">{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deadline" class="col-md-4 col-form-label text-md-right">{{ __('Deadline') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="deadline"
                                           class="form-control{{ $errors->has('deadline') ? ' is-invalid' : '' }}"
                                           name="deadline" value="{{ old('deadline') }}" autocomplete="off">

                                    @if ($errors->has('deadline'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('deadline') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status1" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                <div class="col-md-6">
                                    <select id="status1" class="form-control status" name="status">
                                        <option value="created" class="taskStatus">Created</option>
                                        <option value="assigned" class="taskStatus assigned">Assigned</option>
                                        <option value="inprogress" class="taskStatus">In Progress</option>
                                        <option value="done" class="taskStatus">Done</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row developerName"></div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('daterangecss')
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('createupdate')
    <script src="{{ asset('js/createupdate.js') }}" defer></script>
@endpush

@push('moment')
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
@endpush

@push('daterangepicker')
    <script src="{{ asset('js/daterangepicker.js') }}" defer></script>
@endpush