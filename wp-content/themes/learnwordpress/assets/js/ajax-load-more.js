document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more');
    const postsContainer = document.getElementById('posts-container');
    
    if (!loadMoreBtn || !postsContainer) return;

    let currentPage = 2; // Start from page 2 (page 1 loaded initially)
    let isLoading = false;

    loadMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (isLoading) return;
        
        isLoading = true;
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';
        
        // Create loading spinner
        const spinner = document.createElement('span');
        spinner.className = 'loading-spinner';
        loadMoreBtn.after(spinner);
        
        // AJAX request
        const data = new FormData();
        data.append('action', 'load_more_posts');
        data.append('page', currentPage);
        data.append('nonce', ajaxObject.nonce);

        fetch(ajaxObject.ajax_url, {
            method: 'POST',
            body: data,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Append new posts with fade-in animation
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.data.html;
                
                tempDiv.querySelectorAll('.post').forEach(post => {
                    post.style.opacity = '0';
                    postsContainer.appendChild(post);
                    fadeIn(post);
                });
                
                currentPage++;
                
                // Remove button if no more posts
                if (data.data.is_last_page) {
                    loadMoreBtn.remove();
                    spinner.remove();
                }
            } else {
                showError(data.data.message || 'Error loading posts');
            }
        })
        .catch(error => {
            showError('There was an error loading posts. Please try again.');
            console.error('AJAX Error:', error);
        })
        .finally(() => {
            isLoading = false;
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Load More';
            spinner.remove();
        });
    });

    function fadeIn(element) {
        let opacity = 0;
        const timer = setInterval(() => {
            if (opacity >= 1) {
                clearInterval(timer);
            }
            element.style.opacity = opacity;
            opacity += 0.1;
        }, 50);
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'ajax-error';
        errorDiv.textContent = message;
        postsContainer.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.style.opacity = '0';
            setTimeout(() => errorDiv.remove(), 500);
        }, 5000);
    }
});