import Swal from "sweetalert2";

window.Swal = Swal;

document.addEventListener("livewire:init", () => {
    // Toast
    Livewire.on(
        "swal",
        ({ icon, title, text, timer = 2000, showConfirmButton = false }) => {
            Swal.fire({
                icon,
                title,
                text,
                timer,
                showConfirmButton,
            });
        },
    );

    // Confirm Delete Universal
    Livewire.on(
        "confirm-delete",
        ({
            action,
            slug,
            id,
            title = "Yakin ingin menghapus?",
            text = "",
            confirmButtonText = "Ya, Hapus",
            cancelButtonText = "Batal",
        }) => {
            Swal.fire({
                title,
                text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText,
                cancelButtonText,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(action, {
                        slug,
                        id,
                    });
                }
            });
        },
    );
});
