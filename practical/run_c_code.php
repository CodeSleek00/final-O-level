<?php
// run_c_code.php
header('Content-Type: text/plain');

if(!isset($_POST['code'])){
    echo "No code provided";
    exit;
}

$code = $_POST['code'];

// Create temporary file
$tmpfile = tempnam(sys_get_temp_dir(), 'c_code_') . '.c';
file_put_contents($tmpfile, $code);

// Compile output file
$outfile = tempnam(sys_get_temp_dir(), 'c_output_');
$cmd = "gcc $tmpfile -o $outfile 2>&1";

// Run compilation
$compile_output = shell_exec($cmd);

if($compile_output){
    // Compilation errors
    echo "Compilation Error:\n" . $compile_output;
    unlink($tmpfile);
    unlink($outfile);
    exit;
}

// Run the compiled program
$run_output = shell_exec("$outfile 2>&1");

// Clean up
unlink($tmpfile);
unlink($outfile);

// Return output
echo $run_output;
?>
