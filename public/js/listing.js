document.getElementById('documents').addEventListener('change', function () {
    const list = document.getElementById('uploadedDocsPreview');
    list.innerHTML = '';

    const files = Array.from(this.files);

    if (files.length === 0) {
        list.innerHTML = `
            <li class="list-group-item text-muted">
                No documents uploaded.
            </li>`;
        return;
    }

    files.forEach((file) => {
        const li = document.createElement('li');
        li.className = 'list-group-item list-group-item-action d-flex align-items-center';
        li.style.cursor = 'pointer';

        // icon based on file type
        let icon = 'fa-file';
        if (file.type.includes('pdf')) icon = 'fa-file-pdf';
        if (file.type.includes('image')) icon = 'fa-file-image';

        li.innerHTML = `
            <i class="fa-solid ${icon} me-2 text-primary"></i>
            <span class="text-truncate">${file.name}</span>
        `;

        // open file on click
        li.addEventListener('click', () => {
            const fileURL = URL.createObjectURL(file);
            window.open(fileURL, '_blank');
        });

        list.appendChild(li);
    });
});