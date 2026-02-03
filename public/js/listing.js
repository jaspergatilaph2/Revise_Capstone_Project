const input = document.getElementById('documents'); // your file input
const preview = document.getElementById('uploadedDocsPreview');

input.addEventListener('change', () => {
    preview.innerHTML = ''; // clear previous

    if (input.files.length === 0) {
        preview.innerHTML = '<p class="text-muted mb-0">No documents uploaded.</p>';
        return;
    }

    Array.from(input.files).forEach(file => {
        const fileDiv = document.createElement('div');
        fileDiv.className = 'd-flex align-items-center border rounded p-1 px-2 text-truncate';
        fileDiv.style.maxWidth = '200px'; // adjust width per your layout
        fileDiv.title = file.name; // full name on hover

        // optional: add a small file icon
        const icon = document.createElement('span');
        icon.className = 'me-1';
        icon.innerHTML = '📄'; // simple document emoji, or use Bootstrap icons

        const text = document.createElement('span');
        text.className = 'text-truncate';
        text.textContent = file.name;

        fileDiv.appendChild(icon);
        fileDiv.appendChild(text);
        preview.appendChild(fileDiv);
    });
});