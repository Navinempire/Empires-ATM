<?php
session_start();
require "config/Database.php";
abstract class select extends Database {
    abstract function withdraw($withdraw);
    abstract function deposite($deposit);
    abstract function balance();
}

class work extends select {
    public function withdraw($withdraw){
        $con = $this->connection();
        $input = $_SESSION['username'];
        $query = "SELECT balance FROM users WHERE pin = $input;";
        $data = $con->query($query);
        $array = $data->fetch();
        $balance = $array['balance'];

        if ($balance >= $withdraw) {
            $value = $balance - $withdraw;
            $update = "UPDATE users SET balance = $value WHERE pin = $input";
            $con->query($update);
            echo "<script>
                alert('Withdrawal successful! New balance: ₹$value');
                window.location.href = 'select.php';
            </script>";
        } else {
            echo "<script>
                alert('Insufficient balance!');
                window.location.href = 'select.php';
            </script>";
        }
    }

    public function deposite($deposit){
        $con = $this->connection();
        $input = $_SESSION['username'];
        $query = "SELECT balance FROM users WHERE pin = $input;";
        $data = $con->query($query);
        $array = $data->fetch();
        $balance = $array['balance'];
        $value = $balance + $deposit;
        $update = "UPDATE users SET balance = $value WHERE pin = $input";
        $con->query($update);

        echo "<script>
            alert('Deposit successful! New balance: ₹$value');
            window.location.href = 'select.php';
        </script>";
    }

    public function balance(){
        $con = $this->connection();
        $input = $_SESSION['username'];
        $query = "SELECT balance FROM users WHERE pin = $input;";
        $data = $con->query($query);
        $array = $data->fetch();
        return $array['balance'];
    }
}

$result = new work();
$currentBalance = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['withdraw'])) {
        $result->withdraw($_POST['amount']);
    } elseif (isset($_POST['deposit'])) {
        $result->deposite($_POST['amount']);
    } elseif (isset($_POST['balance'])) {
        $currentBalance = $result->balance();
    } elseif(isset($_POST['back'])){
        echo "<script>
            alert('Welecomw');
            window.location.href = '../Public/index.php';
        </script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ATM Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .atm-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
        }
        .atm-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-custom {
            width: 100%;
            margin-top: 10px;
        }
        .custombtn{
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="atm-card">
        <h2 class="text-center atm-title">ATM Machine</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="amount" class="form-label">Enter Amount</label>
                <input type="number" class="form-control" name="amount" id="amount" placeholder="e.g. 1000" required>
            </div>
            <button type="submit" name="deposit" class="btn btn-success btn-custom">Deposit</button>
            <button type="submit" name="withdraw" class="btn btn-danger btn-custom">Withdraw</button>
        </form>
        <form method="POST">
            <button type="submit" name="balance" class="btn btn-primary btn-custom">Check Balance</button>
        </form>
        <?php if (!empty($currentBalance)): ?>
            <div class="alert alert-info text-center mt-3">
                Current Balance: ₹<?php echo htmlspecialchars($currentBalance); ?>
            </div>
        <?php endif; ?>
        <form method="post">
        <button type="submit" name="back" class="btn btn-dark btn-custom custombtn">BACK</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
