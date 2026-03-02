<?php
// dashboard.php - LUXURY VERSION
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get user's domains
$stmt = $pdo->prepare("
    SELECT d.* 
    FROM domains d 
    WHERE d.user_id = ? 
    ORDER BY d.registered_at DESC
");
$stmt->execute([getUserId()]);
$userDomains = $stmt->fetchAll();

// Get user info
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([getUserId()]);
$user = $stmt->fetch();

// Calculate stats
$totalDomains = count($userDomains);
$activeDomains = array_filter($userDomains, function($domain) {
    return $domain['status'] === 'registered';
});
$totalValue = array_sum(array_column($userDomains, 'price'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Dashboard - Domain Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Dashboard Specific Styles */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
            min-height: 100vh;
        }
        
        .sidebar {
            background: linear-gradient(135deg, rgba(26, 26, 62, 0.9) 0%, rgba(42, 42, 94, 0.9) 100%);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(10px);
        }
        
        .sidebar-menu i {
            margin-right: 15px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .main-content {
            padding: 30px 0;
        }
        
        .user-profile {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .user-avatar {
            width: 100px;
            height: 100px;
            background: var(--luxury-gradient);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .recent-activity {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }
        
        .activity-icon.domain-added {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        
        .activity-icon.domain-renewed {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
        }
        
        .activity-icon.domain-expired {
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
            color: white;
        }
        
        .chart-container {
            height: 300px;
            margin-bottom: 40px;
        }
        
        .progress-ring {
            position: relative;
            width: 120px;
            height: 120px;
        }
        
        .progress-ring circle {
            fill: none;
            stroke-width: 10;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        
        .progress-ring-bg {
            stroke: rgba(255, 255, 255, 0.1);
        }
        
        .progress-ring-fill {
            stroke: url(#gradient);
            stroke-dasharray: 314;
            stroke-dashoffset: calc(314 - (314 * var(--progress)) / 100);
            transition: stroke-dashoffset 1s ease;
        }
        
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem;
            font-weight: bold;
            background: var(--luxury-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .domain-timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .domain-timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--luxury-gradient);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 30px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -36px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--luxury-gradient);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }
    </style>
</head>
<body class="animated-bg">
    <!-- Floating Icons -->
    <div class="floating-icons"></div>
    
    <!-- Luxury Header -->
    <header class="luxury-dashboard-header">
        <div class="container">
            <nav>
                <a href="index.php" class="logo">
                    <i class="fas fa-crown" style="color: var(--gold); margin-right: 10px;"></i>
                    <span class="gradient-text">Dashboard</span>
                </a>
                <div class="nav-links">
                    <a href="index.php" class="luxury-btn" style="background: transparent; border: 1px solid rgba(255, 255, 255, 0.3);">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="logout.php" class="luxury-btn" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.3);">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Dashboard Grid -->
    <div class="container dashboard-grid animate__animated animate__fadeIn">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
                <h3 style="color: white; margin-bottom: 5px;"><?php echo htmlspecialchars($user['username']); ?></h3>
                <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.9rem; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($user['email']); ?>
                </p>
                <div class="luxury-status available" style="font-size: 0.8rem;">
                    <i class="fas fa-check-circle"></i> Premium Member
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-globe"></i> My Domains</a></li>
                <li><a href="#"><i class="fas fa-chart-line"></i> Analytics</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="#"><i class="fas fa-credit-card"></i> Billing</a></li>
                <li><a href="#"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
            
            <!-- Storage Progress -->
            <div style="margin-top: 40px;">
                <h4 style="color: white; margin-bottom: 20px;">Storage</h4>
                <div class="progress-ring">
                    <svg width="120" height="120">
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#667eea" />
                                <stop offset="100%" stop-color="#764ba2" />
                            </linearGradient>
                        </defs>
                        <circle class="progress-ring-bg" cx="60" cy="60" r="50" />
                        <circle class="progress-ring-fill" cx="60" cy="60" r="50" style="--progress: 75;" />
                    </svg>
                    <div class="progress-text">75%</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Section -->
            <div class="luxury-card" style="margin-bottom: 30px;">
                <h1 style="color: white; margin-bottom: 10px;">
                    Welcome back, <span class="gradient-text"><?php echo htmlspecialchars($user['username']); ?></span>! 👑
                </h1>
                <p style="color: rgba(255, 255, 255, 0.7);">
                    Here's what's happening with your domains today.
                </p>
                <div style="display: flex; gap: 20px; margin-top: 20px;">
                    <div style="color: rgba(255, 255, 255, 0.6);">
                        <i class="fas fa-calendar-alt" style="color: var(--gold); margin-right: 10px;"></i>
                        Member since: <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.6);">
                        <i class="fas fa-clock" style="color: var(--gold); margin-right: 10px;"></i>
                        Last login: Today
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="luxury-stat-card animate__animated animate__fadeInLeft">
                    <div style="font-size: 3rem; margin-bottom: 15px;">
                        <i class="fas fa-globe" style="background: var(--luxury-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <div class="luxury-price" style="font-size: 2.5rem;"><?php echo $totalDomains; ?></div>
                    <p style="color: rgba(255, 255, 255, 0.7);">Total Domains</p>
                </div>
                
                <div class="luxury-stat-card animate__animated animate__fadeInUp">
                    <div style="font-size: 3rem; margin-bottom: 15px;">
                        <i class="fas fa-chart-line" style="background: var(--luxury-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <div class="luxury-price" style="font-size: 2.5rem;">$<?php echo number_format($totalValue, 2); ?></div>
                    <p style="color: rgba(255, 255, 255, 0.7);">Total Value</p>
                </div>
                
                <div class="luxury-stat-card animate__animated animate__fadeInUp">
                    <div style="font-size: 3rem; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="background: var(--luxury-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <div class="luxury-price" style="font-size: 2.5rem;"><?php echo count($activeDomains); ?></div>
                    <p style="color: rgba(255, 255, 255, 0.7);">Active Domains</p>
                </div>
                
                <div class="luxury-stat-card animate__animated animate__fadeInRight">
                    <div style="font-size: 3rem; margin-bottom: 15px;">
                        <i class="fas fa-calendar" style="background: var(--luxury-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <div class="luxury-price" style="font-size: 2.5rem;"><?php echo count($userDomains) > 0 ? '30' : '0'; ?></div>
                    <p style="color: rgba(255, 255, 255, 0.7);">Days to Renew</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity animate__animated animate__fadeIn">
                <h3 style="color: white; margin-bottom: 25px;">
                    <i class="fas fa-history" style="color: var(--gold); margin-right: 10px;"></i>
                    Recent Activity
                </h3>
                
                <div class="activity-item">
                    <div class="activity-icon domain-added">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p style="color: white; margin: 0 0 5px 0;">Domain Added</p>
                        <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 0.9rem;">example.com was added to your account</p>
                        <small style="color: rgba(255, 255, 255, 0.4);">2 hours ago</small>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon domain-renewed">
                        <i class="fas fa-redo"></i>
                    </div>
                    <div>
                        <p style="color: white; margin: 0 0 5px 0;">Domain Renewed</p>
                        <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 0.9rem;">mybusiness.net was renewed for 1 year</p>
                        <small style="color: rgba(255, 255, 255, 0.4);">1 day ago</small>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon domain-added">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <p style="color: white; margin: 0 0 5px 0;">SSL Installed</p>
                        <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 0.9rem;">SSL certificate activated for webapp.io</p>
                        <small style="color: rgba(255, 255, 255, 0.4);">3 days ago</small>
                    </div>
                </div>
            </div>

            <!-- Domains Table -->
            <div class="luxury-card" style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 style="color: white; margin: 0;">
                        <i class="fas fa-list" style="color: var(--gold); margin-right: 10px;"></i>
                        Your Domains
                    </h3>
                    <a href="index.php" class="luxury-btn" style="padding: 10px 20px; font-size: 0.9rem;">
                        <i class="fas fa-plus"></i> Add Domain
                    </a>
                </div>
                
                <?php if (empty($userDomains)): ?>
                    <div style="text-align: center; padding: 50px;">
                        <i class="fas fa-globe" style="font-size: 4rem; color: rgba(255, 255, 255, 0.2); margin-bottom: 20px;"></i>
                        <h4 style="color: white; margin-bottom: 15px;">No Domains Yet</h4>
                        <p style="color: rgba(255, 255, 255, 0.6); margin-bottom: 30px;">
                            Start by searching for your perfect domain!
                        </p>
                        <a href="index.php" class="luxury-btn">
                            <i class="fas fa-search"></i> Search Domains
                        </a>
                    </div>
                <?php else: ?>
                    <div class="luxury-table">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Domain Name</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Expires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userDomains as $domain): ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                <i class="fas fa-globe" style="color: var(--gold);"></i>
                                            </div>
                                            <div>
                                                <strong style="color: white;"><?php echo htmlspecialchars($domain['domain_name']); ?></strong>
                                                <span style="color: var(--gold);">.<?php echo htmlspecialchars($domain['extension']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="luxury-status <?php echo $domain['status']; ?>">
                                            <?php echo ucfirst($domain['status']); ?>
                                        </span>
                                    </td>
                                    <td class="luxury-price">$<?php echo number_format($domain['price'], 2); ?></td>
                                    <td style="color: rgba(255, 255, 255, 0.8);">
                                        <?php 
                                        $expires = $domain['expires_at'] ? strtotime($domain['expires_at']) : strtotime('+1 year');
                                        echo date('M d, Y', $expires);
                                        ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 10px;">
                                            <button class="luxury-btn" style="padding: 8px 15px; font-size: 0.8rem; background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.3);">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="luxury-btn" style="padding: 8px 15px; font-size: 0.8rem; background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40, 167, 69, 0.3);">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                            <button class="luxury-btn" style="padding: 8px 15px; font-size: 0.8rem; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.3);">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="luxury-card animate__animated animate__fadeIn">
                <h3 style="color: white; margin-bottom: 25px;">
                    <i class="fas fa-bolt" style="color: var(--gold); margin-right: 10px;"></i>
                    Quick Actions
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <button class="luxury-btn" style="padding: 20px; text-align: left; display: flex; align-items: center;">
                        <i class="fas fa-search" style="font-size: 2rem; margin-right: 15px;"></i>
                        <div>
                            <strong>Search Domains</strong>
                            <p style="margin: 5px 0 0; font-size: 0.9rem; opacity: 0.8;">Find new domains</p>
                        </div>
                    </button>
                    
                    <button class="luxury-btn" style="padding: 20px; text-align: left; display: flex; align-items: center;">
                        <i class="fas fa-redo" style="font-size: 2rem; margin-right: 15px;"></i>
                        <div>
                            <strong>Renew All</strong>
                            <p style="margin: 5px 0 0; font-size: 0.9rem; opacity: 0.8;">Extend all domains</p>
                        </div>
                    </button>
                    
                    <button class="luxury-btn" style="padding: 20px; text-align: left; display: flex; align-items: center;">
                        <i class="fas fa-download" style="font-size: 2rem; margin-right: 15px;"></i>
                        <div>
                            <strong>Export Data</strong>
                            <p style="margin: 5px 0 0; font-size: 0.9rem; opacity: 0.8;">Download reports</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Domain Timeline -->
            <div class="luxury-card" style="margin-top: 30px;">
                <h3 style="color: white; margin-bottom: 25px;">
                    <i class="fas fa-stream" style="color: var(--gold); margin-right: 10px;"></i>
                    Domain Timeline
                </h3>
                <div class="domain-timeline">
                    <?php 
                    $timelineEvents = [
                        ['date' => 'Today', 'event' => 'Domain example.com was added', 'icon' => 'plus'],
                        ['date' => 'Yesterday', 'event' => 'Renewed mybusiness.net', 'icon' => 'redo'],
                        ['date' => 'Last Week', 'event' => 'SSL certificate installed', 'icon' => 'shield-alt'],
                        ['date' => '2 Weeks Ago', 'event' => 'New domain purchased', 'icon' => 'shopping-cart'],
                    ];
                    
                    foreach($timelineEvents as $event):
                    ?>
                    <div class="timeline-item">
                        <div style="color: var(--gold); font-size: 0.9rem; margin-bottom: 5px;">
                            <i class="fas fa-<?php echo $event['icon']; ?>"></i> <?php echo $event['date']; ?>
                        </div>
                        <p style="color: white; margin: 0;"><?php echo $event['event']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Luxury Footer -->
    <footer style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%); padding: 40px 0; margin-top: 50px;">
        <div class="container">
            <div style="text-align: center;">
                <p style="color: rgba(255, 255, 255, 0.5);">
                    &copy; 2024 DomainFinder Premium Dashboard. 
                    <span style="color: var(--gold);">Experience luxury domain management.</span>
                </p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Generate floating icons
            const floatingIcons = document.querySelector('.floating-icons');
            const icons = ['fa-gem', 'fa-star', 'fa-crown', 'fa-bolt', 'fa-shield-alt', 'fa-rocket', 'fa-chart-line', 'fa-globe'];
            
            for (let i = 0; i < 30; i++) {
                const icon = document.createElement('i');
                icon.className = `floating-icon fas ${icons[Math.floor(Math.random() * icons.length)]}`;
                icon.style.left = `${Math.random() * 100}%`;
                icon.style.top = `${Math.random() * 100}%`;
                icon.style.fontSize = `${Math.random() * 20 + 10}px`;
                icon.style.animationDuration = `${Math.random() * 30 + 20}s`;
                icon.style.color = `rgba(255, 255, 255, ${Math.random() * 0.1 + 0.05})`;
                floatingIcons.appendChild(icon);
            }
            
            // Animate progress ring
            const progressRing = document.querySelector('.progress-ring-fill');
            if (progressRing) {
                setTimeout(() => {
                    progressRing.style.transition = 'stroke-dashoffset 2s ease-out';
                }, 1000);
            }
            
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.luxury-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
            
            // Update stats with animation
            function animateCounter(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);
                    element.textContent = value;
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }
            
            // Animate the stat numbers
            setTimeout(() => {
                document.querySelectorAll('.luxury-price').forEach(priceElement => {
                    const text = priceElement.textContent;
                    if (text.includes('$')) {
                        const value = parseFloat(text.replace('$', '').replace(',', ''));
                        if (!isNaN(value)) {
                            priceElement.textContent = '$0';
                            animateCounter(priceElement, 0, value, 2000);
                        }
                    } else {
                        const value = parseInt(text);
                        if (!isNaN(value)) {
                            priceElement.textContent = '0';
                            animateCounter(priceElement, 0, value, 1500);
                        }
                    }
                });
            }, 1000);
            
            // Add click effects to buttons
            document.querySelectorAll('.luxury-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.5);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                    `;
                    
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + D to go to dashboard
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    window.location.href = 'dashboard.php';
                }
                
                // Ctrl/Cmd + H to go home
                if ((e.ctrlKey || e.metaKey) && e.key === 'h') {
                    e.preventDefault();
                    window.location.href = 'index.php';
                }
            });
        });
        
        // CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
