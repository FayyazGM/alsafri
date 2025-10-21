<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" href="{{asset('admin_assets/myimages/IEO_Logo.png')}}" type="image/x-icon">
    <link id="style" href="{{asset('admin_assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" >
    <link href="{{asset('admin_assets/icon-fonts/icons.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin_assets/app-BXaKe1N-.css')}}" />
    <link href="{{asset('admin_assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('admin_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
</head>
<body class="authentication-background">
    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="card custom-card my-4">
                    <div class="card-body p-5">
                        <div class="mb-3 d-flex justify-content-center">
                            <a href="/admin">
                                <img src="{{asset('admin_assets/myimages/IEO_Logo_Final.jpg')}}" alt="logo" class="desktop-logo" style="height: 65px;">
                            </a>
                        </div>
                        <form method="post" id="resetPasswordForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="mb-3">
                                <label for="password" class="form-label text-default">New Password<sup class="fs-12 text-danger">*</sup></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label text-default">Confirm Password<sup class="fs-12 text-danger">*</sup></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary" id="resetPasswordBtn">Reset Password</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0">Back to <a href="{{ route('admin-login') }}" class="text-primary">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ asset('admin_assets/js/script.js') }}"></script>
    <script src="{{asset('admin_assets/js/validate.min.js')}}"></script>
    <script>
        $(function() {
            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#resetPasswordBtn');
                var originalText = btn.html(); // store original button text
                btn.prop('disabled', true).html('Processing...');

                $.ajax({
                    url: "{{ route('admin.password.update') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if(response.success) {
                            alertMessage(response.message, false);
                            setTimeout(function() {
                                window.location.href = "{{ route('admin-login') }}";
                            }, 2000);
                        } else {
                            alertMessage(response.message, true);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Something went wrong.';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alertMessage(msg, true);
                    } 
            });

        });
});
    </script>
</body>
</html>