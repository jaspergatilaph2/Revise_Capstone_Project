document.querySelectorAll('.action-form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = form.querySelector('button');
            if (btn) btn.disabled = true;
        });
    });