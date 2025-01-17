<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Profile</h1>

        <!-- Alert Success -->
        <div id="success-message" class="alert alert-success d-none">
            Profile updated successfully.
        </div>

        <form id="edit-profile-form" action="/profile/edit" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="CSRF_TOKEN_PLACEHOLDER">

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="CURRENT_USER_NAME" required>
                <div class="invalid-feedback" id="name-error"></div>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="CURRENT_USER_EMAIL" required>
                <div class="invalid-feedback" id="email-error"></div>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password (leave blank if not changing)</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="invalid-feedback" id="password-error"></div>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script>
        // Optional: Example of handling form submission (if you use vanilla JS)
        document.getElementById('edit-profile-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.invalid-feedback').forEach((el) => el.textContent = '');
            document.querySelectorAll('.form-control').forEach((el) => el.classList.remove('is-invalid'));

            // Simulate form submission (replace with actual AJAX or form handling)
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                },
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((errors) => {
                            // Display errors
                            Object.entries(errors).forEach(([field, messages]) => {
                                const input = document.getElementById(field);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    document.getElementById(`${field}-error`).textContent = messages[0];
                                }
                            });
                        });
                    } else {
                        // Display success message
                        document.getElementById('success-message').classList.remove('d-none');
                    }
                })
                .catch((error) => console.error('Error:', error));
        });
    </script>
</body>
</html>
