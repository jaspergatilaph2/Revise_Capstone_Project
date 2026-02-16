document.addEventListener("DOMContentLoaded", function () {

    const fileInput = document.getElementById("documents");
    const previewContainer = document.getElementById("uploadedDocsPreview");
    const confirmPreviewContainer = document.getElementById("confirmDocuments");

    const confirmBtn = document.getElementById("confirmSubmitBtn");
    const finalSubmitBtn = document.getElementById("finalSubmit");

    const confirmProjectName = document.getElementById("confirmPlanName");
    const confirmDescription = document.getElementById("confirmDescription");

    const permitForm = document.getElementById("permitForm");

    let selectedFiles = [];

    // ===============================
    // FILE PREVIEW (MAIN FORM)
    // ===============================
    fileInput.addEventListener("change", function (event) {

        selectedFiles = Array.from(event.target.files);
        previewContainer.innerHTML = "";

        if (selectedFiles.length === 0) {
            previewContainer.innerHTML = '<p class="text-muted mb-0">No documents uploaded.</p>';
            return;
        }

        selectedFiles.forEach((file, index) => {

            let fileElement = document.createElement("div");
            fileElement.classList.add("border", "rounded", "p-2", "position-relative");
            fileElement.style.width = "120px";
            fileElement.style.textAlign = "center";

            if (file.type.startsWith("image/")) {
                let img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.classList.add("img-fluid", "rounded");
                img.style.maxHeight = "80px";
                fileElement.appendChild(img);
            } else {
                fileElement.innerHTML += `
                    <div class="text-center">
                        <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                    </div>
                `;
            }

            let fileName = document.createElement("small");
            fileName.classList.add("d-block", "mt-1", "text-truncate");
            fileName.innerText = file.name;

            fileElement.appendChild(fileName);
            previewContainer.appendChild(fileElement);
        });

    });

    // ===============================
    // CONFIRM BUTTON
    // ===============================
    confirmBtn.addEventListener("click", function () {

        const planName = document.getElementById("planName").value;
        const description = document.getElementById("description").value;

        confirmProjectName.innerText = planName || "-";
        confirmDescription.innerText = description || "-";

        confirmPreviewContainer.innerHTML = "";

        if (selectedFiles.length === 0) {
            confirmPreviewContainer.innerHTML = '<p class="text-muted mb-0">No documents uploaded.</p>';
        } else {

            selectedFiles.forEach(file => {

                let fileElement = document.createElement("div");
                fileElement.classList.add("border", "rounded", "p-2");
                fileElement.style.width = "120px";
                fileElement.style.textAlign = "center";

                if (file.type.startsWith("image/")) {
                    let img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.classList.add("img-fluid", "rounded");
                    img.style.maxHeight = "80px";
                    fileElement.appendChild(img);
                } else {
                    fileElement.innerHTML += `
                        <div class="text-center">
                            <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                        </div>
                    `;
                }

                let fileName = document.createElement("small");
                fileName.classList.add("d-block", "mt-1", "text-truncate");
                fileName.innerText = file.name;

                fileElement.appendChild(fileName);
                confirmPreviewContainer.appendChild(fileElement);
            });
        }

        // Show Modal
        let confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        confirmModal.show();
    });

    // ===============================
    // FINAL SUBMIT
    // ===============================
    finalSubmitBtn.addEventListener("click", function () {
        permitForm.submit();
    });

});