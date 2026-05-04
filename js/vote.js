document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[action$="cast_vote.php"]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const selected = form.querySelector('input[name="candidate_id"]:checked');

            if (!selected) {
                event.preventDefault();
                alert('Please select a candidate before submitting your vote.');
                return;
            }

            if (!confirm('Are you sure you want to cast this vote? You cannot change it later.')) {
                event.preventDefault();
            }
        });
    });
});

