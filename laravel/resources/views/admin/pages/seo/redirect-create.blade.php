@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.redirect.list') }}">Redirects</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.redirect.create') }}">Add Redirect</a></li>
        </ul>
        <h1 class="panel-title">Add Redirect</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.redirect.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Add Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">Old URL <em>*</em></label>
                        <input type="text" name="old_url" value="{{ old('old_url', request('old_url')) }}"
                            class="input-box-md @error('old_url') input-invalid @enderror" placeholder="e.g. /old-page" maxlength="500" required>
                        @error('old_url') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">New URL <em>*</em></label>
                        <input type="text" name="new_url" value="{{ old('new_url') }}"
                            class="input-box-md @error('new_url') input-invalid @enderror" placeholder="e.g. /new-page" maxlength="500" required>
                        @error('new_url') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Type <em>*</em></label>
                        <select name="type" class="input-box-md @error('type') input-invalid @enderror" required>
                            <option value="301" @selected(old('type') == '301')>301 (Permanent)</option>
                            <option value="302" @selected(old('type') == '302')>302 (Temporary)</option>
                        </select>
                        @error('type') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Status</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="status" value="1" @checked(old('status', true))>
                            <div class="slider"></div>
                        </label>
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Redirect</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('seo-tab').classList.add('active');
    </script>
@endsection
