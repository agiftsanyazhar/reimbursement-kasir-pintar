@extends('layouts.auth.app')

@section('container')
  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-2 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">{{ $title }}</h5>
              </div>

              @if (session('success'))
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @elseif (session('danger') || $errors->any() || session()->has('alert'))
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                  {{ $errors->first() ?? session('alert') }}
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <form class="row g-3" action="{{ url('login') }}" method="POST">
                @csrf
                <div class="col-12">
                  <label class="form-label fw-bold">NIP<span class="text-danger">*</span></label>
                  <input type="number" name="nip" class="form-control" required>
                </div>

                <div class="col-12">
                  <label class="form-label fw-bold">Password<span class="text-danger">*</span></label>
                  <input type="password" name="password" class="form-control" required>
                </div>

                <span class="text-danger fw-bold">* Wajib diisi</span>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit" onclick="saveForm()">Login</button>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>

  </section>

  <script>
    //  Validasi
    function saveForm() {
      const requiredInputs = [
        { name: 'nip', label: 'NIP' },
        { name: 'password', label: 'Password' },
      ];

      let hasErrors = false;

      requiredInputs.forEach(input => {
        const inputField = document.querySelector(`input[name="${input.name}"], textarea[name="${input.name}"]`);
        if (inputField.value.trim() === '') {
          alertDialog(input.name, input.label);
          hasErrors = true;
        }
      });

      if (!hasErrors) {
        document.getElementById('form-modal').submit();
      }
    }
</script>

@endsection