<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body {
            background: linear-gradient(to bottom, #f0f0f0, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    

    <?php
    // Database connection details
    $host = 'localhost';
    $db = 'user_management';
    $user = 'root';
    $password = '';

    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);

        // Fetch all user records
        $query = "SELECT * FROM users";
        $stmt = $pdo->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Verification Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['mobile']; ?></td>
                    <td><?php echo $user['verified'] ? 'Verified' : 'Not Verified'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Include jQuery from a CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Example jQuery code (you can customize it further)
        $(document).ready(function() {
            // Add a hover effect to the table rows
            $('table tbody tr').hover(
                function() {
                    $(this).css('background-color', '#f9f9f9');
                },
                function() {
                    $(this).css('background-color', '');
                }
            );
        });
    </script>
</body>
</html>
