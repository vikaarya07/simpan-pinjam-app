import Swal from "sweetalert2";

window.Swal = Swal;

document.addEventListener("livewire:init", () => {
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

    Livewire.on("confirm-delete", ({ slug, npk, name }) => {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: `${npk} - ${name}`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-member", { slug });
            }
        });
    });
});
