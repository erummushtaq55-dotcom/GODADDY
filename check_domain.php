<?php
// check_domain.php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = trim($_POST['domain'] ?? '');
    $extension = trim($_POST['extension'] ?? 'com');
    
    // Basic validation
    if (empty($domain)) {
        echo json_encode([
            'error' => 'Domain name is required',
            'available' => false
        ]);
        exit;
    }
    
    // Remove extension if included in domain input
    $domain = str_replace('.' . $extension, '', $domain);
    
    // Check domain format
    if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]$/', $domain)) {
        echo json_encode([
            'error' => 'Invalid domain format',
            'available' => false
        ]);
        exit;
    }
    
    // Full domain name
    $fullDomain = strtolower($domain . '.' . $extension);
    
    try {
        // Check if domain exists in database
        $stmt = $pdo->prepare("SELECT * FROM domains WHERE domain_name = ? AND extension = ?");
        $stmt->execute([$domain, $extension]);
        $existingDomain = $stmt->fetch();
        
        if ($existingDomain) {
            echo json_encode([
                'domain' => $domain,
                'extension' => $extension,
                'full_domain' => $fullDomain,
                'available' => $existingDomain['status'] === 'available',
                'price' => $existingDomain['price'],
                'message' => $existingDomain['status'] === 'available' ? 'Domain is available' : 'Domain is already registered'
            ]);
        } else {
            // Generate a random price for demo purposes
            $price = mt_rand(899, 2499) / 100; // Random price between $8.99 and $24.99
            
            // For demo: 70% chance domain is available
            $available = mt_rand(1, 10) <= 7;
            
            echo json_encode([
                'domain' => $domain,
                'extension' => $extension,
                'full_domain' => $fullDomain,
                'available' => $available,
                'price' => $price,
                'message' => $available ? 'Domain is available' : 'Domain is already registered'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'error' => 'Database error: ' . $e->getMessage(),
            'available' => false
        ]);
    }
} else {
    echo json_encode([
        'error' => 'Invalid request method',
        'available' => false
    ]);
}
?>
