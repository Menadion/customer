document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    const editProfileBtn = document.getElementById("editProfileBtn");
    const cancelEditBtn = document.getElementById("cancelEditBtn");
    const viewMode = document.getElementById("viewMode");
    const editMode = document.getElementById("editMode");

    const openImageModal = document.getElementById("openImageModal");
    const imageModal = document.getElementById("imageModal");
    const closeImageModal = document.getElementById("closeImageModal");

    const profileUpload = document.getElementById("profileUpload");
    const largeProfileImage = document.getElementById("largeProfileImage");
    const uploadBox = document.getElementById("uploadBox");
    const selectedFileName = document.getElementById("selectedFileName");

    if (notificationBtn && notificationBox) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationBox.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!notificationBtn.contains(e.target) && !notificationBox.contains(e.target)) {
                notificationBox.classList.add("hidden");
            }
        });
    }

    if (editProfileBtn && viewMode && editMode) {
        editProfileBtn.addEventListener("click", function () {
            viewMode.classList.add("hidden");
            editMode.classList.remove("hidden");
        });
    }

    if (cancelEditBtn && viewMode && editMode) {
        cancelEditBtn.addEventListener("click", function () {
            editMode.classList.add("hidden");
            viewMode.classList.remove("hidden");
        });
    }

    if (openImageModal && imageModal) {
        openImageModal.addEventListener("click", function () {
            imageModal.classList.remove("hidden");
        });
    }

    if (closeImageModal && imageModal) {
        closeImageModal.addEventListener("click", function () {
            imageModal.classList.add("hidden");
        });
    }

    if (imageModal) {
        imageModal.addEventListener("click", function (e) {
            if (e.target === imageModal) {
                imageModal.classList.add("hidden");
            }
        });
    }

    const profileToggle = document.getElementById("profileToggle");
const profileMenu = document.getElementById("profileMenu");

if (profileToggle) {
    profileToggle.addEventListener("click", function () {
        profileMenu.classList.toggle("hidden");
    });
}

document.addEventListener("click", function (e) {
    if (!profileToggle.contains(e.target)) {
        profileMenu.classList.add("hidden");
    }
});

    function handleSelectedFile(file) {
        if (!file) return false;

        if (!file.type.startsWith("image/")) {
            alert("Please choose an image file only.");
            return false;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert("Image must not exceed 2 MB.");
            return false;
        }

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        profileUpload.files = dataTransfer.files;

        if (selectedFileName) {
            selectedFileName.textContent = file.name;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            if (largeProfileImage) {
                largeProfileImage.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);

        return true;
    }

    if (profileUpload) {
        profileUpload.addEventListener("change", function () {
            const file = this.files[0];
            handleSelectedFile(file);
        });
    }

    if (uploadBox) {
        uploadBox.addEventListener("dragover", function (e) {
            e.preventDefault();
            uploadBox.classList.add("drag-over");
        });

        uploadBox.addEventListener("dragleave", function (e) {
            e.preventDefault();
            uploadBox.classList.remove("drag-over");
        });

        uploadBox.addEventListener("drop", function (e) {
            e.preventDefault();
            uploadBox.classList.remove("drag-over");

            const file = e.dataTransfer.files[0];
            handleSelectedFile(file);
        });
    }

  const changePasswordToggle = document.getElementById("changePasswordToggle");
    const passwordFields = document.getElementById("passwordFields");

    if (changePasswordToggle && passwordFields) {
        changePasswordToggle.addEventListener("change", function () {
            if (this.checked) {
                passwordFields.classList.remove("hidden");
            } else {
                passwordFields.classList.add("hidden");
            }
        });
    }
});