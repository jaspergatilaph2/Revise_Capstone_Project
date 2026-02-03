function printPermit(permitId) {
    // Get modal content
    const modalContent = document.getElementById(`permitDetails-${permitId}`);
    if (!modalContent) return alert('Permit details not found.');

    // Get the table row for this permit
    const permitRow = document.querySelector(`#viewDocumentModal-${permitId}`).closest('tr');
    let rowContent = '';
    if (permitRow) {
        rowContent = permitRow.cloneNode(true);

        // Remove buttons, modals, and columns not needed for print
        rowContent.querySelectorAll('button, .modal').forEach(el => el.remove());

        // Remove the "Documents" (4th) and "Actions" (8th) columns
        const tds = rowContent.querySelectorAll('td');
        if (tds.length >= 8) {
            tds[3].remove(); // Documents
            tds[7].remove(); // Actions
        }

        // Replace empty values with N/A
        rowContent.querySelectorAll('td').forEach(td => {
            if (!td.textContent.trim()) td.textContent = 'N/A';
        });
    }

    // Clone modal content
    const clonedModal = modalContent.cloneNode(true);

    // Remove buttons inside the modal
    clonedModal.querySelectorAll('button').forEach(btn => btn.remove());

    // Replace images and iframes with links
    clonedModal.querySelectorAll('iframe, img').forEach(el => {
        let src = '';
        if (el.tagName.toLowerCase() === 'iframe') src = el.src;
        if (el.tagName.toLowerCase() === 'img') src = el.src;

        if (src) {
            const link = document.createElement('a');
            link.href = src;
            link.target = '_blank';
            link.style.display = 'block';
            link.style.marginBottom = '10px';
            link.textContent = src.split('/').pop(); // Show the file name
            el.parentNode.replaceChild(link, el);
        } else {
            el.remove();
        }
    });

    // Combine Form 1 and Form 2 tables into a single table
    let combinedTableHTML = '<table class="table table-bordered table-striped"><thead class="table-light"><tr><th>Field</th><th>Value</th></tr></thead><tbody>';

    clonedModal.querySelectorAll('table').forEach((table, tableIndex) => {
        const caption = tableIndex === 0 ? 'Unified Application Form 1 Details' : 'Unified Application Form 2 Details';

        // Add a row as a section header inside tbody
        combinedTableHTML += `<tr style="background-color:#f1f3f5; font-weight:600;"><td colspan="2">${caption}</td></tr>`;

        table.querySelectorAll('tbody tr').forEach(tr => {
            const th = tr.querySelector('th');
            const td = tr.querySelector('td');
            if (th && td) {
                let value = td.textContent.trim();

                // Decode JSON arrays
                if (value.startsWith('[')) {
                    try {
                        const arr = JSON.parse(value);
                        if (Array.isArray(arr)) value = arr.join(', ');
                    } catch (e) { }
                }

                // Format Estimated Cost
                if (th.textContent.trim().toLowerCase() === 'estimated cost' && !isNaN(parseFloat(value))) {
                    value = '₱' + parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                combinedTableHTML += `<tr><th>${th.textContent.trim()}</th><td>${value}</td></tr>`;
            }
        });
    });

    combinedTableHTML += '</tbody></table>';

    // Construct logo URL dynamically
    const logoUrl = window.location.origin + '/images/municipality_logo.jpg';

    // Open print window
    const printWindow = window.open('', '', 'width=1200,height=900');

    // Write HTML
    printWindow.document.write(`
<html>
<head>
    <title>Permit Details</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; font-family: Arial, sans-serif; color: #333; }
        h2, h4, h6 { margin-top: 20px; margin-bottom: 15px; }
        h2 { border-bottom: 2px solid #333; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; page-break-inside: auto; }
        th, td { padding: 8px 12px; border: 1px solid #dee2e6; vertical-align: top; }
        th { background-color: #f8f9fa; text-align: left; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        a { color: #007bff; text-decoration: underline; margin-bottom: 10px; display: block; }
        hr { border-top: 1px solid #dee2e6; margin: 25px 0; }
        .section-title { background-color: #f1f3f5; padding: 8px 12px; border-left: 4px solid #5b86e5; font-weight: 600; margin-bottom: 10px; }
        .header-text { text-align: center; margin-bottom: 30px; }
        .header-text img { max-height: 80px; margin-bottom: 10px; }
        .header-text span { display: block; font-weight: 600; font-size: 14px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <!-- Government Header with Logo -->
    <div class="header-text">
        <img src="${logoUrl}" alt="Municipality Logo">
        <span>Republic of the Philippines</span>
        <span>Municipality of Bontoc</span>
        <span>Province of Southern Leyte</span>
    </div>

    <h2>Permit Details</h2>

    <!-- Main Permit Table -->
    <div class="section-title">Permit Summary</div>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Project Name</th>
                <th>Location</th>
                <th>Status</th>
                <th>Reviewed By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            ${rowContent.outerHTML}
        </tbody>
    </table>

    <hr>

    <!-- Combined Form Details -->
    <div class="section-title">Unified Application Forms Details</div>
    ${combinedTableHTML}

</body>
</html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
