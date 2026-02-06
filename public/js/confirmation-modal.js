document.addEventListener("DOMContentLoaded", function () {
    const radiusRange = document.getElementById("radiusRange");
    const radiusValue = document.getElementById("radiusValue");
    const confirmBtn = document.getElementById("confirmSubmitBtn");
    const finalSubmit = document.getElementById("finalSubmit");
    const form = document.getElementById("permitForm");
    const modalEl = document.getElementById("confirmModal");
    const input = document.getElementById('documents');

    let filesArray = [];

    // 🔹 Live radius display
    radiusRange.addEventListener("input", function () {
        radiusValue.textContent = `${this.value} meters`;
    });

    // 🔹 Handle file selection
    input.addEventListener('change', (event) => {
        const newFiles = Array.from(event.target.files);
        filesArray = filesArray.concat(newFiles);
        input.value = '';
        renderFilePreview(document.getElementById('uploadedDocsPreview'), true);
    });

    function renderFilePreview(container, allowRemove = false) {
        container.innerHTML = '';
        if (filesArray.length === 0) {
            container.innerHTML = '<p class="text-muted mb-0">No documents uploaded.</p>';
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.classList.add('d-flex', 'flex-wrap', 'gap-2');

        filesArray.forEach((file, idx) => {
            const fileDiv = document.createElement('div');
            fileDiv.classList.add('border', 'p-2', 'text-center', 'rounded');
            fileDiv.style.width = '120px';
            fileDiv.style.position = 'relative';

            const fileType = file.type;
            const fileURL = URL.createObjectURL(file);

            if (fileType.startsWith('image/')) {
                fileDiv.innerHTML = `<img src="${fileURL}" alt="${file.name}" style="width:100%;height:100px;object-fit:cover;" class="rounded">`;
            } else if (fileType === 'application/pdf') {
                fileDiv.innerHTML = `
                    <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size:48px;"></i>
                    <small class="text-truncate">${file.name}</small>`;
            } else {
                fileDiv.innerHTML = `
                    <i class="bi bi-file-earmark-fill text-secondary" style="font-size:48px;"></i>
                    <small class="text-truncate">${file.name}</small>`;
            }

            if (allowRemove) {
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute');
                removeBtn.style.top = '2px';
                removeBtn.style.right = '5px';
                removeBtn.onclick = (e) => {
                    e.stopPropagation();
                    filesArray.splice(idx, 1);
                    renderFilePreview(container, true);
                };
                fileDiv.appendChild(removeBtn);
            }

            fileDiv.onclick = () => {
                const docPreview = document.getElementById('docPreviewContainer');
                if (fileType.startsWith('image/')) {
                    docPreview.innerHTML = `<img src="${fileURL}" class="img-fluid rounded">`;
                } else if (fileType === 'application/pdf') {
                    docPreview.innerHTML = `<iframe src="${fileURL}" width="100%" height="600" style="border:none;"></iframe>`;
                } else {
                    docPreview.innerHTML = `<p class="text-muted">Preview not available</p>`;
                }
                new bootstrap.Modal(document.getElementById('docPreviewModal')).show();
            };

            wrapper.appendChild(fileDiv);
        });

        container.appendChild(wrapper);
    }

    confirmBtn.addEventListener('click', () => {
        // Populate modal fields
        document.getElementById('confirmProjectName').textContent = document.getElementById('project_name').value || 'N/A';
        document.getElementById('confirmAddress').textContent = document.getElementById('address').value || 'N/A';
        document.getElementById('confirmLocation').textContent = document.getElementById('location').value || 'N/A';
        const cost = parseFloat(document.getElementById('project_cost').value) || 0;
        document.getElementById('confirmProjectCost').textContent = `₱${cost.toLocaleString()}`;
        document.getElementById('confirmRadius').textContent = document.getElementById('radiusRange').value || '0';
        document.getElementById('confirmDescription').textContent = document.getElementById('description').value || 'N/A';

        // Render files in modal (no remove buttons)
        renderFilePreview(document.getElementById('confirmDocuments'), false);

        // Show modal
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // After modal is fully visible, initialize map
        modalEl.addEventListener('shown.bs.modal', () => {
            const mapContainer = document.getElementById('confirmMap');
            mapContainer.innerHTML = ''; // clear previous map if any

            const lat = parseFloat(document.getElementById('latitude').value) || 14.5995;
            const lng = parseFloat(document.getElementById('longitude').value) || 120.9842;
            const radius = parseInt(document.getElementById('radiusRange').value) || 0;

            const modalMap = L.map(mapContainer).setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(modalMap);

            // Add marker
            L.marker([lat, lng]).addTo(modalMap).bindPopup("Project Location").openPopup();

            // Add radius circle
            if (radius > 0) {
                L.circle([lat, lng], {
                    radius: radius,
                    color: "#007bff",
                    fillColor: "#007bff",
                    fillOpacity: 0.2,
                }).addTo(modalMap);

                // Fit bounds so circle is fully visible
                modalMap.fitBounds([
                    [lat + 0.01, lng + 0.01],
                    [lat - 0.01, lng - 0.01]
                ]);
            }

            // Fix Leaflet rendering inside hidden modal
            setTimeout(() => modalMap.invalidateSize(), 300);
        }, { once: true });
    });

    // 🔹 Final submit
    finalSubmit.addEventListener('click', (e) => {
        e.preventDefault();
        finalSubmit.disabled = true;
        finalSubmit.textContent = 'Submitting...';

        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;

        form.submit(); // ✅ sends POST to /apply/store
    });



});
