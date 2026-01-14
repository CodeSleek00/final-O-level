<?php
include '../db_connect.php';
$subject_id = 1; // IT Tools (M1-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 IT Tools Practice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --accent: #f59e0b;
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.12);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            margin: 0;
            color: var(--text-dark);
        }

        /* Page Container */
        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            border-radius: 20px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
            color: white;
            text-align: center;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 14px;
            font-weight: 600;
            border-radius: 50px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-banner h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-banner p {
            font-size: 18px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            background: white;
            color: var(--primary);
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            background: #f8fafc;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
            border: 1px solid var(--border);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--primary);
            font-size: 24px;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-dark);
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Content Sections */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        .section-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-badge {
            padding: 6px 14px;
            background: var(--primary);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .test-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .test-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .test-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .test-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .test-card p {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            padding: 12px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-light);
        }

        .stat i {
            color: var(--primary);
        }

        .start-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .start-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-wrapper {
                padding: 15px;
            }

            .hero-banner {
                padding: 40px 20px;
                margin-bottom: 30px;
            }

            .hero-banner h1 {
                font-size: 32px;
            }

            .hero-banner p {
                font-size: 16px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .feature-card {
                padding: 25px;
            }

            .test-card {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            .hero-banner {
                padding: 30px 15px;
            }

            .hero-banner h1 {
                font-size: 28px;
            }

            .cta-btn {
                padding: 14px 28px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include '../navbar.html'; ?>

    <div class="page-wrapper">
        <!-- Hero Banner -->
        <section class="hero-banner">
            <div class="badge">
                <i class="fas fa-book-open"></i> NIELIT O Level Syllabus
            </div>
            <h1>Master IT Tools with Smart Practice</h1>
            <p>
                Ace your M1-R5 exam with comprehensive MCQ practice based on the latest NIELIT syllabus. 
                Track progress, identify weak areas, and boost confidence with our intelligent practice system.
            </p>
            <a href="#mock-tests" class="cta-btn">
                <i class="fas fa-rocket"></i> Start Practicing Now
            </a>
        </section>

        <!-- Features -->
        <section class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Updated Syllabus Coverage</h3>
                <p>All MCQs strictly follow latest NIELIT O Level M1-R5 syllabus with regular updates.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Intelligent Progress Tracking</h3>
                <p>Monitor your performance with detailed analytics and personalized recommendations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <h3>Exam-Style Practice</h3>
                <p>Timed tests and realistic exam patterns to improve speed and accuracy under pressure.</p>
            </div>
        </section>

        <!-- Mock Tests Section -->
        <section id="mock-tests">
            <div class="section-header">
                <h2><i class="fas fa-file-alt"></i> Complete Mock Tests</h2>
                <span class="section-badge">Exam Simulation</span>
            </div>

            <div class="cards-grid">
                <?php
                $q = $conn->query("SELECT * FROM test_sets WHERE subject_id=$subject_id");
                while($row = $q->fetch_assoc()){
                    $countQ = $conn->query("
                        SELECT COUNT(*) AS total 
                        FROM questions 
                        WHERE set_id={$row['id']}
                    ")->fetch_assoc();
                ?>
                <div class="test-card">
                    <h3><?= htmlspecialchars($row['set_name']); ?></h3>
                    <p>Full-length practice test covering all topics from the syllabus</p>
                    
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-question-circle"></i>
                            <span><?= $countQ['total']; ?> Questions</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-clock"></i>
                            <span>60 Minutes</span>
                        </div>
                    </div>

                    <a class="start-btn" href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['id']; ?>">
                        <i class="fas fa-play-circle"></i> Start Test
                    </a>
                </div>
                <?php } ?>
            </div>
        </section>

        <!-- Chapter-wise Practice -->
        <section>
            <div class="section-header">
                <h2><i class="fas fa-layer-group"></i> Chapter-wise Practice</h2>
                <span class="section-badge">Focus Learning</span>
            </div>

            <div class="cards-grid">
                <?php
                $q = $conn->query("SELECT * FROM chapters WHERE subject_id=$subject_id");
                while($ch = $q->fetch_assoc()){
                    $count = $conn->query("
                        SELECT COUNT(*) total 
                        FROM chapter_questions 
                        WHERE chapter_id={$ch['id']}
                    ")->fetch_assoc();
                ?>
                <div class="test-card">
                    <h3><?= htmlspecialchars($ch['chapter_name']); ?></h3>
                    <p>Master individual topics with focused practice questions</p>
                    
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-question-circle"></i>
                            <span><?= $count['total']; ?> Questions</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-bullseye"></i>
                            <span>Topic Focused</span>
                        </div>
                    </div>

                    <a class="start-btn" href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
                        <i class="fas fa-brain"></i> Practice Now
                    </a>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>

    <script>
        // Smooth scroll for CTA button
        document.querySelector('.cta-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#mock-tests').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Add hover effects to cards
        document.querySelectorAll('.test-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>