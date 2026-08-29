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
                        id,
                    });
                }
            });
        },
    );

    // Confirm Download PDF
    Livewire.on(
        "confirm-download-pdf",
        ({
            action,
            title = "Download Laporan?",
            text = "",
            confirmButtonText = "Ya, Download",
            cancelButtonText = "Batal",
        }) => {
            Swal.fire({
                title,
                text,
                icon: "question",
                showCancelButton: true,
                confirmButtonText,
                cancelButtonText,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(action);
                }
            });
        },
    );
});
