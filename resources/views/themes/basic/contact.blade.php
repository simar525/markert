@extends('themes.basic.layouts.single')
@section('noindex', true)
@section('title', translate('Contact US'))
@section('breadcrumbs', Breadcrumbs::render('contact'))
@section('header_v3', true)
@section('content')
    <form action="{{ route('contact') }}" method="POST">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-12 col-lg-6">
                <label class="form-label">{{ translate('Name') }}</label>
                <input type="text" name="name" class="form-control form-control-md"
                    value="{{ auth()->user() ? auth()->user()->getName() : '' }}" required>
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label">{{ translate('Email') }}</label>
                <input type="email" name="email" class="form-control form-control-md"
                    value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">{{ translate('Subject') }}</label>
                <input type="text" name="subject" class="form-control form-control-md" value="{{ old('subject') }}"
                    required>
            </div>
            <div class="col-12">
                <label class="form-label">{{ translate('Message') }}</label>
                <textarea class="form-control" name="message" rows="8" required>{{ old('message') }}</textarea>
            </div>
        </div>
        <x-captcha />
        <button class="btn btn-primary btn-md px-5">{{ translate('Send') }}</button>
    </form>
@endsection
