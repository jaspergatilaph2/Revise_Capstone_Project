function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const original = document.getElementById('print-area');

    // Clone the print area to avoid altering the original
    const clone = original.cloneNode(true);

    // Remove all buttons from the clone
    clone.querySelectorAll('button, .no-print').forEach(el => el.remove());

    // Off-screen container to render clone
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.appendChild(clone);
    document.body.appendChild(tempContainer);

    // Create jsPDF instance
    const pdf = new jsPDF('p', 'pt', 'a4');

    // Calculate scale based on A4 width
    const pdfWidth = pdf.internal.pageSize.getWidth() - 20; // 10pt margin
    const scale = pdfWidth / clone.scrollWidth;

    pdf.html(clone, {
        callback: function (doc) {
            doc.save('unified-application-form.pdf');
            tempContainer.remove();
        },
        x: 10, // left margin
        y: 10, // top margin
        html2canvas: {
            scale: scale,      // ensures high resolution on all devices
            useCORS: true,     // load images from server
            logging: false,    // suppress console logs
            scrollY: -window.scrollY, // prevent clipping on mobile
            windowWidth: clone.scrollWidth,
        },
        windowWidth: clone.scrollWidth,

        // Ensure Box 5 always starts on a new page
        pagebreak: {
            mode: ['css', 'legacy'],
            before: '#box-5'
        }
    });
}

function CivildownloadPDF() {
    const { jsPDF } = window.jspdf;
    const original = document.getElementById('print-area');

    // Clone the print area to avoid altering the original
    const clone = original.cloneNode(true);

    // Remove all buttons from the clone
    clone.querySelectorAll('button, .no-print').forEach(el => el.remove());

    // Off-screen container to render clone
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.appendChild(clone);
    document.body.appendChild(tempContainer);

    // Create jsPDF instance
    const pdf = new jsPDF('p', 'pt', 'a4');

    // Calculate scale based on A4 width
    const pdfWidth = pdf.internal.pageSize.getWidth() - 20; // 10pt margin
    const scale = pdfWidth / clone.scrollWidth;

    pdf.html(clone, {
        callback: function (doc) {
            doc.save('civil-permit-application-form.pdf');
            tempContainer.remove();
        },
        x: 10, // left margin
        y: 10, // top margin
        html2canvas: {
            scale: scale,      // ensures high resolution on all devices
            useCORS: true,     // load images from server
            logging: false,    // suppress console logs
            scrollY: -window.scrollY, // prevent clipping on mobile
            windowWidth: clone.scrollWidth,
        },
        windowWidth: clone.scrollWidth,

        // Ensure Box 5 always starts on a new page
        pagebreak: {
            mode: ['css', 'legacy'],
            before: '#box-9'
        }
    });
}

function ArchitecturaldownloadPDF() {
    const { jsPDF } = window.jspdf;
    const original = document.getElementById('print-area');

    // Clone the print area to avoid altering the original
    const clone = original.cloneNode(true);

    // Remove all buttons from the clone
    clone.querySelectorAll('button, .no-print').forEach(el => el.remove());

    // Off-screen container to render clone
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.appendChild(clone);
    document.body.appendChild(tempContainer);

    // Create jsPDF instance
    const pdf = new jsPDF('p', 'pt', 'a4');

    // Calculate scale based on A4 width
    const pdfWidth = pdf.internal.pageSize.getWidth() - 20; // 10pt margin
    const scale = pdfWidth / clone.scrollWidth;

    pdf.html(clone, {
        callback: function (doc) {
            doc.save('Architectural-Permit-form.pdf');
            tempContainer.remove();
        },
        x: 10, // left margin
        y: 10, // top margin
        html2canvas: {
            scale: scale,      // ensures high resolution on all devices
            useCORS: true,     // load images from server
            logging: false,    // suppress console logs
            scrollY: -window.scrollY, // prevent clipping on mobile
            windowWidth: clone.scrollWidth,
        },
        windowWidth: clone.scrollWidth,

        // Ensure Box 5 always starts on a new page
        pagebreak: {
            mode: ['css', 'legacy'],
            before: '#box-9'
        }
    });
}

function ElectricaldownloadPDF() {
    const { jsPDF } = window.jspdf;
    const original = document.getElementById('print-area');

    // Clone the print area to avoid altering the original
    const clone = original.cloneNode(true);

    // Remove all buttons from the clone
    clone.querySelectorAll('button, .no-print').forEach(el => el.remove());

    // Off-screen container to render clone
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.appendChild(clone);
    document.body.appendChild(tempContainer);

    // Create jsPDF instance
    const pdf = new jsPDF('p', 'pt', 'a4');

    // Calculate scale based on A4 width
    const pdfWidth = pdf.internal.pageSize.getWidth() - 20; // 10pt margin
    const scale = pdfWidth / clone.scrollWidth;

    pdf.html(clone, {
        callback: function (doc) {
            doc.save('Electrical-Permit-form.pdf');
            tempContainer.remove();
        },
        x: 10, // left margin
        y: 10, // top margin
        html2canvas: {
            scale: scale,      // ensures high resolution on all devices
            useCORS: true,     // load images from server
            logging: false,    // suppress console logs
            scrollY: -window.scrollY, // prevent clipping on mobile
            windowWidth: clone.scrollWidth,
        },
        windowWidth: clone.scrollWidth,

        // Ensure Box 5 always starts on a new page
        pagebreak: {
            mode: ['css', 'legacy'],
            before: '#box-9'
        }
    });
}

function PlumbingdownloadPDF() {
    const { jsPDF } = window.jspdf;
    const original = document.getElementById('print-area');

    // Clone the print area to avoid altering the original
    const clone = original.cloneNode(true);

    // Remove all buttons from the clone
    clone.querySelectorAll('button, .no-print').forEach(el => el.remove());

    // Off-screen container to render clone
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.appendChild(clone);
    document.body.appendChild(tempContainer);

    // Create jsPDF instance
    const pdf = new jsPDF('p', 'pt', 'a4');

    // Calculate scale based on A4 width
    const pdfWidth = pdf.internal.pageSize.getWidth() - 20; // 10pt margin
    const scale = pdfWidth / clone.scrollWidth;

    pdf.html(clone, {
        callback: function (doc) {
            doc.save('Plumbing-Permit-form.pdf');
            tempContainer.remove();
        },
        x: 10, // left margin
        y: 10, // top margin
        html2canvas: {
            scale: scale,      // ensures high resolution on all devices
            useCORS: true,     // load images from server
            logging: false,    // suppress console logs
            scrollY: -window.scrollY, // prevent clipping on mobile
            windowWidth: clone.scrollWidth,
        },
        windowWidth: clone.scrollWidth,

        // Ensure Box 5 always starts on a new page
        pagebreak: {
            mode: ['css', 'legacy'],
            before: '#box-9'
        }
    });
}