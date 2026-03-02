<?php
// register_domain.php
require_once 'config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to register a domain']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = trim($_POST['domain'] ?? '');
    $extension = trim($_POST['extension'] ?? 'com');
    
    if (empty($domain)) {
        echo json_encode(['success' => false, 'message' => 'Domain name is required']);
        exit;
    }
    
    try {
        // Check if domain exists and is available
        $stmt = $pdo->prepare("SELECT * FROM domains WHERE domain_name = ? AND extension = ?");
        $stmt->execute([$domain, $extension]);
        $existingDomain = $stmt->fetch();
        
        if ($existingDomain) {
            if ($existingDomain['status'] !== 'available') {
                echo json_encode(['success' => false, 'message' => 'Domain is not available']);
                exit;
            }
            
            // Update existing domain record
            $stmt = $pdo->prepare("
                UPDATE domains 
                SET status = 'registered', 
                    user_id = ?, 
                    registered_at = NOW(), 
                    expires_at = DATE_ADD(NOW(), INTERVAL 1 YEAR)
                WHERE id = ?
            ");
            $stmt->execute([getUserId(), $existingDomain['id']]);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Domain registered successfully!',
                'domain' => $domain . '.' . $extension
            ]);
        } else {
            // Create new domain record
            $price = mt_rand(899, 2499) / 100;
            
            $stmt = $pdo->prepare("
                INSERT INTO domains (domain_name, extension, status, price, user_id, registered_at, expires_at)
                VALUES (?, ?, 'registered', ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))
            ");
            $stmt->execute([$domain, $extension, $price, getUserId()]);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Domain registered successfully!',
                'domain' => $domain . '.' . $extension,
                'price' => $price
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
