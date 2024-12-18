<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <body>
        <div class="container light-style flex-grow-1 container-p-y">
            <!-- Back Button -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3" style="position: absolute; top: 20px; left: 20px;">
                <i class="fas fa-arrow-left"></i> Back
            </a>          

    <style>
    body {
        background: #ffffff;
        margin-top: 20px;
    }

    .ui-w-80 {
        width: 150px !important;
        height: auto;
        border: 3px solid #0d0808; /* Dark gray border */
        border-radius: 8px; /* Slightly rounded edges */
        padding: 4px; /* Space between image and border */
    }

    .btn-default {
        border-color: rgba(24, 28, 33, 0.1);
        background: rgba(0, 0, 0, 0);
        color: #4E5155;
    }

    .btn-outline-primary {
        border-color: #26B4FF;
        background: transparent;
        color: #26B4FF;
    }

    .text-light {
        color: #babbbc !important;
    }

    .card {
        background-clip: padding-box;
        box-shadow: 0 1px 4px rgba(8, 9, 10, 0.012);
        border-radius: 20px;
    }

    .account-settings-fileinput {
        position: absolute;
        visibility: hidden;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .account-settings-links .list-group-item.active {
        font-weight: bold !important;
    }
</style>

</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">Profile</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifications</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Account General Tab -->
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="d-block ui-w-80">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" name="profile_picture" class="account-settings-fileinput" disabled>
                                        </label>
                                        <button type="button" class="btn btn-default md-btn-flat" id="resetProfilePic">Reset</button>
                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ $user->name }}" name="name" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control mb-1" value="{{ $user->email }}" name="email" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control mb-1" value="{{ $user->phone_number }}" name="phone_number" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Account Change Password Tab -->
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" name="current_password" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" name="new_password" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirm new password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Account Info Tab -->                           
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" name="bio" rows="5" disabled>{{ $user->bio }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="date" class="form-control" name="birthday" value="{{ $user->birthday }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <select class="custom-select" name="country" disabled>
                                            <option {{ $user->country == 'USA' ? 'selected' : '' }}>Labangal</option>
                                            <option {{ $user->country == 'Canada' ? 'selected' : '' }}>Silway</option>
                                            <option {{ $user->country == 'UK' ? 'selected' : '' }}>San Isidro</option>                                    
                                            <!-- Add other countries as necessary -->
                                        </select>
                                    </div>                                  
                                    <!-- Gender Selection -->
                                    <div class="form-group">
                                        <label class="form-label">Gender</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" {{ $user->gender == 'male' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ $user->gender == 'female' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" {{ $user->gender == 'other' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Account Notifications Tab -->
                            <div class="tab-pane fade" id="account-notifications">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Email Notifications</label>
                                        <select class="custom-select" name="email_notifications" disabled>
                                            <option {{ $user->email_notifications ? 'selected' : '' }}>Enabled</option>
                                            <option {{ !$user->email_notifications ? 'selected' : '' }}>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center" style="height: 80px; padding-top: 20px;">
                    <button type="button" id="edit-save-button" class="btn btn-primary" onclick="toggleEdit()">Edit</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Handle the reset button to clear the file input
        document.getElementById('resetProfilePic').addEventListener('click', function () {
            const fileInput = document.querySelector('input[name="profile_picture"]');
            fileInput.value = ''; // Reset the input
        });

        function toggleEdit() {
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            const button = document.getElementById('edit-save-button');
            
            if (button.innerText === 'Edit') {
                inputs.forEach(input => input.disabled = false);
                button.innerText = 'Save Changes';
                button.onclick = function() {
                    form.submit();
                };
            } else {
                form.submit(); // Only submits when "Save Changes" is clicked
            }
        }
    </script>
</body>
</html>

