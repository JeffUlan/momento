document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("create-post-modal-trigger")
    .addEventListener("click", () => {
      const modal = new bootstrap.Modal(
        document.getElementById("create-post-modal")
      );
      modal.show();
    });

  document.getElementById("post-image").addEventListener("change", (event) => {
    const input = event.target;
    const imagePreview = document.getElementById("create-post-image");

    if (input.files && input.files[0]) {
      const reader = new FileReader();

      reader.onload = (e) => {
        imagePreview.src = e.target.result;
      };

      reader.readAsDataURL(input.files[0]);
    } else {
      imagePreview.innerHTML = "";
    }
  });
});
