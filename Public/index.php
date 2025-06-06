<?php
session_start();
require "../Private/config/Database.php";

class Welcom extends Database {
    public function firstview() {
        $con = $this->connection();
        $query = "SELECT * FROM users";
        $result = $con->query($query);
        $array = $result->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function validation($input) {
        $data = $this->firstview();
        $invalid = 0;

        foreach ($data as $user) {
            if ($input == $user['pin']) {
                $_SESSION['username'] = $input;
                echo "<script>
                    alert('PIN correct! Redirecting...');
                    window.location.href = '../Private/select.php';
                </script>";
                return;
            } else {
                $invalid++;
            }
        }

        if ($invalid == count($data)) {
            echo "<script>
                alert('Invalid PIN. Please try again.');
                window.location.href = 'index.php';
            </script>";
        }
    }
}

$data = new Welcom();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['input'])) {
        $data->validation($_POST['pin']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ATM PIN Entry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .pin-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-control {
            font-size: 18px;
            text-align: center;
            letter-spacing: 5px;
        }
        .btn-primary {
            width: 100%;
            margin-top: 15px;
        }
        h2 {
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }
        h1 {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 56px;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            letter-spacing: 2px;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }


    </style>
</head>
<body>
    <h1>Empires Bank</h1>
    <div class="pin-card">
        <h2>Enter Your PIN</h2>
        <form method="POST">
            <input type="number" name="pin" class="form-control" placeholder="****" required maxlength="4" />
            <button type="submit" name="input" class="btn btn-primary">ENTER PIN</button>
        </form>
    </div>
    

    <!-- Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
