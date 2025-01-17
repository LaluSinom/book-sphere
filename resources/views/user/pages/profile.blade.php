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

        <form action="{{ route('profile.update') }}" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
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
