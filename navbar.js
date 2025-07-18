
    document.addEventListener('DOMContentLoaded', function() {
      const hamburger = document.getElementById('hamburger');
      const navLinks = document.getElementById('navLinks');
      const navItems = document.querySelectorAll('.nav-item');
      
      // Mobile menu toggle
      hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        navLinks.classList.toggle('active');
      });
      
      // Handle both hover and click interactions
      navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        const dropdown = item.querySelector('.dropdown');
        
        if (!dropdown) return;
        
        // Hover functionality for desktop
        item.addEventListener('mouseenter', function() {
          if (window.innerWidth > 768) {
            closeAllDropdowns();
            dropdown.classList.add('active');
          }
        });
        
        // Click functionality for all devices
        link.addEventListener('click', function(e) {
          if (window.innerWidth <= 768) {
            e.preventDefault();
            item.classList.toggle('active');
            dropdown.classList.toggle('active');
          } else {
            // On desktop, keep dropdown open after click
            e.preventDefault();
            closeAllDropdowns();
            dropdown.classList.add('active');
          }
        });
      });
      
      // Close dropdowns when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item') && !e.target.closest('.hamburger')) {
          closeAllDropdowns();
          
          if (window.innerWidth <= 768 && navLinks.classList.contains('active')) {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
          }
        }
      });
      
      function closeAllDropdowns() {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
          dropdown.classList.remove('active');
        });
        document.querySelectorAll('.nav-item').forEach(item => {
          item.classList.remove('active');
        });
      }
      
      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
          hamburger.classList.remove('active');
          navLinks.classList.remove('active');
          closeAllDropdowns();
        }
      });
    });
