<x-app-layout>
    @section('title', 'Settings | TDS Attendance')

    <div class="container-fluid py-4 px-3 px-lg-4">
        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Settings</h1>
            <p class="text-muted mb-0">Manage your teacher and institute details.</p>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Please correct the following:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="teacher_name" class="form-label fw-semibold">Teacher Name <span class="text-danger">*</span></label>
                            <input type="text" id="teacher_name" name="teacher_name" class="form-control @error('teacher_name') is-invalid @enderror" value="{{ old('teacher_name', $setting?->teacher_name) }}" required maxlength="255">
                            @error('teacher_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="institute_name" class="form-label fw-semibold">Institute Name</label>
                            <input type="text" id="institute_name" name="institute_name" class="form-control @error('institute_name') is-invalid @enderror" value="{{ old('institute_name', $setting?->institute_name) }}" maxlength="255">
                            @error('institute_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="contact_number" class="form-label fw-semibold">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number', $setting?->contact_number) }}" maxlength="30">
                            @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $setting?->email) }}" maxlength="255">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="default_subject" class="form-label fw-semibold">Default Subject <span class="text-danger">*</span></label>
                            <input type="text" id="default_subject" name="default_subject" class="form-control @error('default_subject') is-invalid @enderror" value="{{ old('default_subject', $setting?->default_subject ?? 'Dancing') }}" required maxlength="100">
                            @error('default_subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="logo" class="form-label fw-semibold">Institute Logo</label>
                            <input type="file" id="logo" name="logo" accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp" class="form-control @error('logo') is-invalid @enderror">
                            <div class="form-text">PNG, JPG, or WEBP. Maximum file size: 2 MB.</div>
                            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if ($setting?->logo)
                            <div class="mt-3">
                                <div class="small text-muted mb-2">Current logo</div>
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Institute logo" class="border rounded-3 p-2 bg-white" style="max-width: 180px; max-height: 100px; object-fit: contain;">
                            </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror" maxlength="2000">{{ old('address', $setting?->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2-circle me-1"></i> Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>