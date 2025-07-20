<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>O level Practice</title>
</head>
<body>
    <?php include 'navbar.html'; ?>
    
    <div class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Prepare For O Level & CCC</h1>
                <p>Comprehensive practice for O Level, CCC, CCC+, and more. Perfect your knowledge and ace your certifications with interactive exercises and mock tests.</p>
                <a href="#signup" class="cta-button">Start Learning Today</a>
                
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number">10,000+</span>
                        <span class="stat-label">Practice Questions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">95%</span>
                        <span class="stat-label">Success Rate</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Access</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Student studying with laptop">
            </div>
        </section>
    </div>
    <section class="join-us-section">
    <div class="join-us-content">
        <h1>Join Faiz Computer Institute Today!</h1>
        <p>Unlock a world of opportunities with expert courses, interactive learning, and a supportive community. At Faiz Computer Institute, we empower students to reach their full potential and achieve their career goals. Start your learning journey now!</p>
        <a href="https://faizcomputerinstitute.com" target="_blank" class="join-btn">Join Now</a>
    </div>
</section>
 <div class="practice">
    <div class="boxes">
      <h2>O Level Practice</h2>
      <p>Comprehensive questions designed to help you ace your O Level exams.</p>
      <a href="#">Start</a>
    </div>

    <div class="boxes">
      <h2>CCC Practice</h2>
      <p>Comprehensive questions designed to help you ace your CCC exams.</p>
      <a href="#">Start</a>
    </div>

    <div class="boxes">
      <h2>Chapter-wise MCQs</h2>
      <p>Practice MCQs for each chapter to strengthen your concepts.</p>
      <a href="#">Start</a>
    </div>

    <div class="boxes">
      <h2>Practical Portal</h2>
      <p>Master practical skills with our step-by-step guides.</p>
      <a href="#">Start</a>
    </div>
  </div>
  <section>
    <h2>Our Expert Services</h2>
    <p class="intro">
      We deliver premium solutions crafted for your specific requirements, guaranteeing exceptional outcomes. Benefit from dependable assistance,
      <mark>streamlined</mark>
      workflows, and customized care to accomplish your objectives effortlessly.
    </p>

    <div class="grid">
      <div class="card">
        <div class="icon-container">
         <img width="100" height="100" src="https://img.icons8.com/clouds/100/workstation.png" alt="workstation"/>
        </div>
        <h3>SHORTCUT KEYS</h3>
        <p>Master keyboard shortcuts to work faster and more efficiently across all applications, reducing reliance on mouse navigation.</p>
        <a href="#" class="btn">Learn More</a>
      </div>

      <div class="card">
        <div class="icon-container">
          <img width="100" height="100" src="https://img.icons8.com/clouds/100/ok.png" alt="ok"/>
        </div>
        <h3>MS-OFFICE</h3>
        <p>Comprehensive training in Word, Excel, PowerPoint and more to maximize your productivity with Microsoft's powerful suite.</p>
        <a href="#" class="btn">Learn More</a>
      </div>

      <div class="card">
        <div class="icon-container">
         <img width="100" height="100" src="https://img.icons8.com/clouds/100/test-passed.png" alt="test-passed"/>
        </div>
        <h3>PROGRAMMING</h3>
        <p>From Python to JavaScript, master coding languages through hands-on projects and real-world applications.</p>
        <a href="#" class="btn">Learn More</a>
      </div>

      <div class="card">
        <div class="icon-container">
         <img width="150" height="150" src="https://img.icons8.com/clouds/150/imac-idea.png" alt="imac-idea"/>
        </div>
        <h3>EXAMS & PRACTICALS</h3>
        <p>Interactive assessments with instant feedback to evaluate your knowledge and track your learning progress.</p>
        <a href="#" class="btn">Learn More</a>
      </div>

      <div class="card">
        <div class="icon-container">
          <img width="100" height="100" src="https://img.icons8.com/clouds/100/repository.png" alt="repository"/>
        </div>
        <h3>TALLY SOLUTIONS</h3>
        <p>Complete financial management training including accounting, inventory, payroll and GST using Tally software.</p>
        <a href="#" class="btn">Learn More</a>
      </div>

      <div class="card">
        <div class="icon-container">
         <img width="100" height="100" src="https://img.icons8.com/clouds/100/macbook-idea.png" alt="macbook-idea"/>
        </div>
        <h3>STUDY MATERIALS</h3>
        <p>Curated resources and concise notes designed for effective learning and quick revision of key concepts.</p>
        <a href="#" class="btn">Learn More</a>
      </div>
    </div>
  </section>
 <script>
    // Add simple animation when cards come into view
    const cards = document.querySelectorAll('.card');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      card.style.transition = `all 0.5s ease ${index * 0.1}s`;
      observer.observe(card);
    });

    // Add click effect to cards
    cards.forEach(card => {
      card.addEventListener('click', function() {
        this.style.transform = 'scale(0.98)';
        setTimeout(() => {
          this.style.transform = 'translateY(-8px)';
        }, 150);
      });
    });
  </script>
</body>
</html>