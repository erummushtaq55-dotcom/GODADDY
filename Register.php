<?php
// register.php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Username must be between 3 and 50 characters';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->rowCount() > 0) {
                $error = 'Username or email already exists';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password]);
                
                // Get the new user ID
                $user_id = $pdo->lastInsertId();
                
                // Auto login after registration
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                
                $success = 'Registration successful! Redirecting to dashboard...';
                
                // Redirect after 2 seconds
                header("refresh:2;url=dashboard.php");
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DomainFinder</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .password-strength {
            margin-top: 5px;
            height: 5px;
            border-radius: 3px;
            transition: all 0.3s;
        }
        
        .strength-weak {
            background: #dc3545;
            width: 25%;
        }
        
        .strength-medium {
            background: #ffc107;
            width: 50%;
        }
        
        .strength-strong {
            background: #28a745;
            width: 100%;
        }
        
        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        .requirement {
            margin: 5px 0;
            display: flex;
            align-items: center;
        }
        
        .requirement i {
            margin-right: 10px;
            width: 20px;
        }
        
        .requirement.valid {
            color: #28a745;
        }
        
        .requirement.invalid {
            color: #6c757d;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <a href="index.php" class="logo">DomainFinder</a>
                <div class="nav-links">
                    <a href="index.php">Home</a>
                    <a href="login.php">Login</a>
                    <a href="register.php" class="btn btn-outline">Register</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Registration Form -->
    <section class="dashboard">
        <div class="container">
            <div style="max-width: 500px; margin: 50px auto;">
                <div class="search-box">
                    <h2 style="text-align: center; margin-bottom: 30px;">Create Your Account</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" id="registrationForm">
                        <div class="form-group">
                            <label for="username">
                                <i class="fas fa-user"></i> Username
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="form-control" 
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                                   required
                                   placeholder="Enter your username"
                                   minlength="3"
                                   maxlength="50">
                            <small style="color: #6c757d;">3-50 characters, letters and numbers only</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control" 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                   required
                                   placeholder="Enter your email address">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   required
                                   placeholder="Create a strong password"
                                   minlength="6"
                                   onkeyup="checkPasswordStrength()">
                            <div id="passwordStrength" class="password-strength"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">
                                <i class="fas fa-lock"></i> Confirm Password
                            </label>
                            <input type="password" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   class="form-control" 
                                   required
                                   placeholder="Re-enter your password"
                                   minlength="6"
                                   onkeyup="checkPasswordMatch()">
                            <small id="passwordMatch" style="display: none; color: #28a745;">
                                <i class="fas fa-check"></i> Passwords match
                            </small>
                            <small id="passwordNoMatch" style="display: none; color: #dc3545;">
                                <i class="fas fa-times"></i> Passwords do not match
                            </small>
                        </div>
                        
                        <!-- Password Requirements -->
                        <div class="password-requirements">
                            <h4>Password Requirements:</h4>
                            <div class="requirement invalid" id="reqLength">
                                <i class="far fa-circle"></i> At least 6 characters
                            </div>
                            <div class="requirement invalid" id="reqNumber">
                                <i class="far fa-circle"></i> Contains a number
                            </div>
                            <div class="requirement invalid" id="reqUppercase">
                                <i class="far fa-circle"></i> Contains uppercase letter
                            </div>
                            <div class="requirement invalid" id="reqLowercase">
                                <i class="far fa-circle"></i> Contains lowercase letter
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="form-group" style="margin-top: 20px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="terms" id="terms" required style="margin-right: 10px;">
                                I agree to the <a href="#" style="color: #667eea;">Terms and Conditions</a> and <a href="#" style="color: #667eea;">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>
                    
                    <div class="login-link">
                        <p>Already have an account? <a href="login.php" style="color: #667eea; font-weight: bold;">Login here</a></p>
                    </div>
                    
                    <!-- Demo Account Info -->
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px; text-align: center;">
                        <p style="margin: 0; font-size: 0.9rem; color: #6c757d;">
                            <strong>Demo Account:</strong> admin / 123456
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p style="text-align: center;">&copy; 2024 DomainFinder. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrength');
            
            // Reset
            strengthBar.className = 'password-strength';
            
            // Check requirements
            const hasMinLength = password.length >= 6;
            const hasNumber = /\d/.test(password);
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            
            // Update requirement indicators
            updateRequirement('reqLength', hasMinLength);
            updateRequirement('reqNumber', hasNumber);
            updateRequirement('reqUppercase', hasUppercase);
            updateRequirement('reqLowercase', hasLowercase);
            
            // Calculate strength
            let strength = 0;
            if (hasMinLength) strength++;
            if (hasNumber) strength++;
            if (hasUppercase) strength++;
            if (hasLowercase) strength++;
            
            // Update strength bar
            if (strength === 0) {
                strengthBar.style.display = 'none';
            } else if (strength <= 1) {
                strengthBar.style.display = 'block';
                strengthBar.className = 'password-strength strength-weak';
            } else if (strength <= 2) {
                strengthBar.style.display = 'block';
                strengthBar.className = 'password-strength strength-medium';
            } else {
                strengthBar.style.display = 'block';
                strengthBar.className = 'password-strength strength-strong';
            }
            
            // Also check password match
            checkPasswordMatch();
        }
        
        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            if (isValid) {
                element.className = 'requirement valid';
                element.innerHTML = '<i class="fas fa-check-circle"></i> ' + element.textContent.replace('●', '');
            } else {
                element.className = 'requirement invalid';
                element.innerHTML = '<i class="far fa-circle"></i> ' + element.textContent.replace('✓', '');
            }
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchElement = document.getElementById('passwordMatch');
            const noMatchElement = document.getElementById('passwordNoMatch');
            
            if (confirmPassword.length === 0) {
                matchElement.style.display = 'none';
                noMatchElement.style.display = 'none';
                return;
            }
            
            if (password === confirmPassword) {
                matchElement.style.display = 'block';
                noMatchElement.style.display = 'none';
            } else {
                matchElement.style.display = 'none';
                noMatchElement.style.display = 'block';
            }
        }
        
        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const terms = document.getElementById('terms').checked;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (!terms) {
                e.preventDefault();
                alert('You must agree to the Terms and Conditions');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long');
                return false;
            }
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkPasswordStrength();
            
            // Add real-time username validation
            const usernameInput = document.getElementById('username');
            usernameInput.addEventListener('blur', function() {
                const username = this.value.trim();
                if (username.length > 0) {
                    // Check username availability (you can implement AJAX call here)
                    const usernamePattern = /^[a-zA-Z0-9_]+$/;
                    if (!usernamePattern.test(username)) {
                        alert('Username can only contain letters, numbers, and underscores');
                        this.focus();
                    }
                }
            });
        });
    </script>
</body>
</html>
