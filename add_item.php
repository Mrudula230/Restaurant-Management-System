<?php
include "config.php";
$error = "";

// CREATE : runs when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $category = $_POST["category"];
    $price    = $_POST["price"];

    // server side validation
    if ($name == "") {
        $error = "Item name is required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Price must be a number greater than 0.";
    } else {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, category, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $category, $price);
        $stmt->execute();
        header("Location: menu.php?msg=added");
        exit();
    }
}

$page_title = "Add Menu Item";
include "header.php";
?>

<h2>Add Menu Item</h2>

<?php if ($error != "") { ?>
    <div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post" action="add_item.php">
    <label for="name">Item Name</label>
    <input type="text" id="name" name="name" required>

    <label for="category">Category</label>
    <select id="category" name="category">
        <option>Starter</option>
        <option>Main Course</option>
        <option>Breakfast</option>
        <option>Dessert</option>
        <option>Beverage</option>
    </select>

    <label for="price">Price (Rs.)</label>
    <input type="number" id="price" name="price" step="0.01" min="1" required>

    <button type="submit">Save Item</button>
</form>

<?php include "footer.php"; ?>
