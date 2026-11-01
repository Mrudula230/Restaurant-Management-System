<?php
include "config.php";
$error = "";

// DELETE an order (when the bill is paid)
if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: order.php");
    exit();
}

// CREATE an order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_no = (int) $_POST["table_no"];
    $item_id  = (int) $_POST["item_id"];
    $quantity = (int) $_POST["quantity"];

    if ($table_no <= 0 || $quantity <= 0) {
        $error = "Table number and quantity must be greater than 0.";
    } else {
        $stmt = $conn->prepare("INSERT INTO orders (table_no, item_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $table_no, $item_id, $quantity);
        $stmt->execute();
        header("Location: order.php");
        exit();
    }
}

$page_title = "Orders";
include "header.php";

// items for the drop-down list
$items = $conn->query("SELECT id, name, price FROM menu_items ORDER BY name");

// orders joined with menu items to get the name and price
$orders = $conn->query("SELECT o.id, o.table_no, m.name, m.price, o.quantity, o.order_time
                        FROM orders o JOIN menu_items m ON o.item_id = m.id
                        ORDER BY o.id DESC");
$grand_total = 0;
?>

<h2>Take an Order</h2>

<?php if ($error != "") { ?>
    <div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post" action="order.php">
    <label for="table_no">Table Number</label>
    <input type="number" id="table_no" name="table_no" min="1" required>

    <label for="item_id">Menu Item</label>
    <select id="item_id" name="item_id">
        <?php while ($item = $items->fetch_assoc()) { ?>
            <option value="<?php echo $item["id"]; ?>">
                <?php echo htmlspecialchars($item["name"]); ?> (Rs. <?php echo $item["price"]; ?>)
            </option>
        <?php } ?>
    </select>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" min="1" value="1" required>

    <button type="submit">Place Order</button>
</form>

<h2>Current Orders</h2>

<table>
    <tr>
        <th>Order</th><th>Table</th><th>Item</th><th>Qty</th><th>Amount (Rs.)</th><th>Time</th><th>Action</th>
    </tr>
    <?php while ($row = $orders->fetch_assoc()) {
        $amount = $row["price"] * $row["quantity"];
        $grand_total = $grand_total + $amount;
    ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["table_no"]; ?></td>
        <td><?php echo htmlspecialchars($row["name"]); ?></td>
        <td><?php echo $row["quantity"]; ?></td>
        <td><?php echo number_format($amount, 2); ?></td>
        <td><?php echo $row["order_time"]; ?></td>
        <td><a class="delete" href="order.php?delete=<?php echo $row["id"]; ?>"
               onclick="return confirm('Mark as paid and remove?');">Paid</a></td>
    </tr>
    <?php } ?>
    <tr>
        <th colspan="4" style="text-align:right;">Grand Total</th>
        <th colspan="3">Rs. <?php echo number_format($grand_total, 2); ?></th>
    </tr>
</table>

<?php include "footer.php"; ?>
