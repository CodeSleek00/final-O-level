<?php
include("../db_connect.php");
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = "LibreOffice Writer";

// Build query with search functionality
$sql = "SELECT * FROM shortcuts WHERE category='$category'";
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (shortcut_key LIKE '%$search%' OR description LIKE '%$search%')";
}
$sql .= " ORDER BY shortcut_key ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibreOffice Writer Shortcut Keys | Faiz Computer Institute</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        .keyboard-key {
            display: inline-block;
            padding: 2px 8px;
            margin: 2px;
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            border: 1px solid #d1d5db;
            border-radius: 4px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', monospace;
            font-weight: 600;
            color: #374151;
        }
        .key-combination {
            white-space: nowrap;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'navbar.html'; ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-file-word text-blue-600 mr-3"></i>
                LibreOffice Writer Shortcut Keys
            </h1>
            <p class="text-gray-600 text-lg">Master your document editing with these essential keyboard shortcuts</p>
            
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <form method="GET" action="">
                        <input type="text" 
                               name="search" 
                               value="<?php echo htmlspecialchars($search); ?>"
                               placeholder="Search shortcuts or descriptions..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                <div class="flex gap-3">
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    </form>
                    <?php if (!empty($search)): ?>
                        <a href="?search=" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition duration-300 flex items-center">
                            <i class="fas fa-times mr-2"></i> Clear
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($search)): ?>
                <div class="mt-4 text-sm text-gray-600">
                    Showing results for: "<span class="font-semibold"><?php echo htmlspecialchars($search); ?></span>"
                    (<?php echo $result->num_rows; ?> results found)
                </div>
            <?php endif; ?>
        </div>

        <!-- Shortcuts Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/3">
                                <i class="fas fa-keyboard mr-2"></i>Shortcut Key
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-2/3">
                                <i class="fas fa-info-circle mr-2"></i>Description
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="key-combination">
                                            <?php 
                                            // Parse and format keyboard shortcuts
                                            $keys = explode('+', $row['shortcut_key']);
                                            foreach ($keys as $index => $key):
                                                $key = trim($key);
                                                $key_class = strtolower($key);
                                            ?>
                                                <kbd class="keyboard-key <?php echo $key_class; ?>">
                                                    <?php echo htmlspecialchars($key); ?>
                                                </kbd>
                                                <?php if ($index < count($keys) - 1): ?>
                                                    <span class="mx-1 text-gray-400">+</span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <div class="flex items-start">
                                            <div class="flex-1">
                                                <?php echo htmlspecialchars($row['description']); ?>
                                            </div>
                                            <button onclick="copyToClipboard('<?php echo htmlspecialchars($row['shortcut_key']); ?>')" 
                                                    class="ml-4 p-2 text-gray-400 hover:text-blue-600 transition"
                                                    title="Copy shortcut">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-search fa-3x mb-4"></i>
                                        <p class="text-xl font-medium">No shortcuts found</p>
                                        <p class="mt-2">
                                            <?php if (!empty($search)): ?>
                                                Try different search terms or clear the search
                                            <?php else: ?>
                                                No shortcuts available in this category
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

      

    <script>
        // Copy shortcut to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show success feedback
                const originalText = text;
                const button = event.target.closest('button');
                const icon = button.querySelector('i');
                const originalClass = icon.className;
                
                icon.className = 'fas fa-check text-green-500';
                button.title = 'Copied!';
                
                setTimeout(() => {
                    icon.className = originalClass;
                    button.title = 'Copy shortcut';
                }, 2000);
            });
        }

        // Highlight search terms in table
        document.addEventListener('DOMContentLoaded', function() {
            const searchTerm = "<?php echo addslashes($search); ?>";
            if (searchTerm) {
                const cells = document.querySelectorAll('td');
                cells.forEach(cell => {
                    const html = cell.innerHTML;
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    cell.innerHTML = html.replace(regex, '<span class="bg-yellow-200 px-1 rounded">$1</span>');
                });
            }
        });
    </script>
</body>
</html>