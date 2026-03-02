// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Domain search functionality
    const searchForm = document.getElementById('domainSearchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const domainInput = document.getElementById('domainInput');
            const extensionSelect = document.getElementById('extensionSelect');
            
            if (domainInput.value.trim()) {
                searchDomain(domainInput.value, extensionSelect.value);
            }
        });
    }

    // Extension tag click handlers
    document.querySelectorAll('.extension-tag').forEach(tag => {
        tag.addEventListener('click', function() {
            const extension = this.getAttribute('data-ext');
            document.getElementById('extensionSelect').value = extension;
        });
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});

// Domain search function
function searchDomain(domainName, extension) {
    const resultsDiv = document.getElementById('searchResults');
    const loadingDiv = document.getElementById('loading');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (resultsDiv) resultsDiv.innerHTML = '';
    
    fetch('check_domain.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `domain=${encodeURIComponent(domainName)}&extension=${encodeURIComponent(extension)}`
    })
    .then(response => response.json())
    .then(data => {
        if (loadingDiv) loadingDiv.style.display = 'none';
        if (resultsDiv) {
            resultsDiv.innerHTML = `
                <div class="domain-card">
                    <div class="domain-name">${data.domain}.${data.extension}</div>
                    <div class="domain-status status-${data.available ? 'available' : 'registered'}">
                        ${data.available ? 'Available' : 'Registered'}
                    </div>
                    ${data.available ? `
                        <div class="domain-price">$${data.price}/year</div>
                        <button class="btn" onclick="registerDomain('${data.domain}', '${data.extension}', ${data.price})">
                            Register Now
                        </button>
                    ` : ''}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (loadingDiv) loadingDiv.style.display = 'none';
        if (resultsDiv) {
            resultsDiv.innerHTML = '<div class="alert alert-error">Error checking domain availability</div>';
        }
    });
}

// Register domain function
function registerDomain(domain, extension, price) {
    if (!confirm(`Register ${domain}.${extension} for $${price}/year?`)) return;
    
    fetch('register_domain.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `domain=${encodeURIComponent(domain)}&extension=${encodeURIComponent(extension)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Domain registered successfully!');
            window.location.href = 'dashboard.php';
        } else {
            alert('Error: ' + data.message);
        }
    });
}

// Toggle domain details
function toggleDomainDetails(domainId) {
    const details = document.getElementById(`details-${domainId}`);
    if (details) {
        details.style.display = details.style.display === 'none' ? 'block' : 'none';
    }
}
