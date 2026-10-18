@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.testimonial.list') }}">Testimonials</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.testimonial.create') }}">Add Testimonial</a></li>
        </ul>
        <h1 class="panel-title">Add Testimonial</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.testimonial.create') }}" method="POST" enctype="multipart/form-data">
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

                    {{-- Client Name --}}
                    <div class="input-group">
                        <label for="client_name" class="input-label">Client Name <em>*</em></label>
                        <input type="text" name="client_name" value="{{ old('client_name') }}"
                            class="input-box-md @error('client_name') input-invalid @enderror" placeholder="Enter Client Name"
                            minlength="1" maxlength="250" required>
                        @error('client_name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Company Name --}}
                    <div class="input-group">
                        <label for="company_name" class="input-label">Company Name <span>(Optional)</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="input-box-md @error('company_name') input-invalid @enderror" placeholder="Enter Company Name"
                            minlength="1" maxlength="250">
                        @error('company_name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Feedback --}}
                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label for="feedback" class="input-label">Feedback / Testimonial <em>*</em></label>
                        <textarea name="feedback" id="feedback" rows="5"
                            class="input-box-md @error('feedback') input-invalid @enderror" placeholder="Enter client's feedback"
                            minlength="1" maxlength="1000" required>{{ old('feedback') }}</textarea>
                        @error('feedback')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Company Logo --}}
                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label for="company_logo" class="input-label">Company Logo <span>(Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleLogoPreview(event)" name="company_logo">
                                <i data-feather="upload-cloud"></i>
                                <span>Darg and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="logo_preview"
                                alt="logo_preview" class="input-thumbnail-preview">
                        </div>
                        @error('company_logo')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="company_logo_alt" value="{{ old('company_logo_alt') }}"
                            class="input-box-md mt-2 @error('company_logo_alt') input-invalid @enderror"
                            placeholder="Alt text (for SEO/accessibility)" maxlength="255">
                        @error('company_logo_alt')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Testimonial</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('testimonial-tab').classList.add('active');

        const handleLogoPreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('logo_preview').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('logo_preview').src = URL.createObjectURL(event.target.files[0])
            }
        }
    </script>
@endsection
