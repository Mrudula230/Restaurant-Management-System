<?php
include "config.php";
$page_title = "Dashboard";
include "header.php";

// COUNT and SUM queries for the dashboard cards
$total_items  = $conn->query("SELECT COUNT(*) AS c FROM menu_items")->fetch_assoc()["c"];
$total_orders = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()["c"];
$sales_row    = $conn->query("SELECT SUM(o.quantity * m.price) AS total
                              FROM orders o JOIN menu_items m ON o.item_id = m.id")->fetch_assoc();
$total_sales  = $sales_row["total"] ? $sales_row["total"] : 0;
?>

<h2>Dashboard</h2>

<div class="cards">
    <div class="card">
        <div class="number"><?php echo $total_items; ?></div>
        Menu Items
    </div>
    <div class="card">
        <div class="number"><?php echo $total_orders; ?></div>
        Orders Taken
    </div>
    <div class="card">
        <div class="number">Rs. <?php echo number_format($total_sales, 2); ?></div>
        Total Sales
    </div>
</div>

<p style="margin-top:25px;">
    <a class="btn" href="menu.php">View Menu</a>
    <a class="btn" href="add_item.php">Add Menu Item</a>
    <a class="btn" href="order.php">Take an Order</a>
</p>

<?php include "footer.php"; ?>
