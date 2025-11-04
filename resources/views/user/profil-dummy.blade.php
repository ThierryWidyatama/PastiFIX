<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dummy</title>

    <!-- Bootstrap (opsional tapi berguna untuk modal) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />

    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 100%;
            object-fit: cover;
            border: 3px solid #ddd;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="p-4">

    <h2>Profile Dummy</h2>

    <!-- Foto Profil -->
    <div class="text-center mt-4">
        <img id="profilePreview" 
            src="https://via.placeholder.com/150" 
            class="profile-img mb-3" />

        <div>
            <input type="file" id="inputImage" accept="image/*" class="form-control" style="width: 250px; margin: auto;">
        </div>
    </div>

    <!-- Modal Crop -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Foto</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <img id="imageCropper" style="max-width: 100%; display:block; margin:auto;">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" id="btnCrop">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        let cropper;
        const inputImage = document.getElementById("inputImage");
        const imageCropper = document.getElementById("imageCropper");
        const profilePreview = document.getElementById("profilePreview");

        const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

        // Ketika pilih file
        inputImage.onchange = function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                imageCropper.src = e.target.result;

                // Jika cropper sudah ada → destroy dulu
                if (cropper) {
                    cropper.destroy();
                }

                cropModal.show();

                setTimeout(() => {
                    cropper = new Cropper(imageCropper, {
                        aspectRatio: 1,
                        viewMode: 2,
                        dragMode: 'move',
                        autoCropArea: 1,
                    });
                }, 300);
            };

            reader.readAsDataURL(file);
        };

        // Tombol Crop
        document.getElementById("btnCrop").onclick = function () {
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
            });

            const base64 = canvas.toDataURL("image/png");

            // Tampilkan ke preview sebelum upload
            profilePreview.src = base64;

            // Kirim ke server (Laravel)
            fetch("{{ route('profil.upload') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ image: base64 })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Uploaded:", data);
            });

            cropModal.hide();
        };
    </script>

</body>
</html>
