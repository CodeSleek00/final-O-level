<?php
// run_python.php
// This file executes Python code sent from the frontend via POST

header('Content-Type: text/plain'); // Output plain text

// Allow CORS if frontend is on same domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if code is sent
if (!isset($_POST['code'])) {
    echo "Error: No code received!";
    exit;
}

// Get the code from POST
$code = $_POST['code'] ?? '';

// Sanitize: remove any dangerous characters (basic)
$code = str_replace(['`', ';'], '', $code);

// Create a temporary file to save Python code
$tempFile = tempnam(sys_get_temp_dir(), 'pycode_') . '.py';

// Write the code to the temp file
file_put_contents($tempFile, $code);

// Execute the Python file
// Use python3, adjust if server uses python
// 2>&1 redirects stderr to stdout
$output = shell_exec("python3 " . escapeshellarg($tempFile) . " 2>&1");

// Delete the temporary file
unlink($tempFile);

// Return the output
echo $output;
 