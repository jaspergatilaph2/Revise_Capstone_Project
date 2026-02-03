/**
 * printPermit.js
 * Prints permit details including table content and document previews
 */

document.addEventListener("DOMContentLoaded", function () {

    // Delegate click on any button with class "btn-print-permit"
    document.body.addEventListener("click", function (e) {
        if (e.target.closest(".btn-print-permit")) {
            e.preventDefault();

            const btn = e.target.closest(".btn-print-permit");
            const permitId = btn.dataset.permitId;

            if (!permitId) return;

            // Get the modal content
            const modal = document.querySelector(`#viewDocumentModal-${permitId}`);
            if (!modal) {
                console.error("Permit modal not found:", permitId);
                return;
            }

            // Clone the modal content
            const content = modal.querySelector(".modal-body").cloneNode(true);

            // Optional: remove buttons inside cloned content
            const buttons = content.querySelectorAll("button");
            buttons.forEach(b => b.remove());

            // Optional: remove modal-specific classes (Bootstrap spacing)
            content.querySelectorAll(".modal-body, .ratio, .img-fluid").forEach(el => {
                el.style.maxWidth = "100%";
            });

            // Open new window for printing
            const printWindow = window.open("", "_blank", "width=900,height=600");

            // Header HTML
            const headerHTML = `
                <div style="position: relative; text-align: center; margin-bottom: 20px; padding: 10px;">
                    <img src="${window.location.origin}/images/Municipality_logo.jpg"
                        alt="Municipality Logo"
                        style="position: absolute; left: 10px; top: 10px; width: 80px; height: auto;">
                    <h4 style="font-weight: bold; margin: 0; padding: 0 50px;">
                        <span style="display: block;">Republic of the Philippines</span>
                        <span style="display: block;">Municipality of Bontoc</span>
                        <span style="display: block;">Province of Southern Leyte</span>
                        <span style="display: block; margin-top: 10px; font-size: 1.2rem;">
                            UNIFIED APPLICATION FORM FOR BUILDING PERMIT
                        </span>
                    </h4>
                </div>
            `;

            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Permit</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            table, th, td { border: 1px solid #000; }
                            th, td { padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                            img { max-width: 100%; margin-bottom: 10px; }
                            iframe { width: 100%; height: 500px; border: 0; margin-bottom: 10px; }
                        </style>
                    </head>
                    <body>
                        ${headerHTML}
                        ${content.innerHTML}
                    </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    });

});
