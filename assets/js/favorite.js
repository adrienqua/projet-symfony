document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const taskId = this.dataset.taskId;
            const icon = this.querySelector('span');

            fetch(`/task/${taskId}/toggle-favorite`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.isFavorite) {
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-red-500');
                        this.dataset.isFavorite = 'true';
                    } else {
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-gray-400');
                        this.dataset.isFavorite = 'false';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});