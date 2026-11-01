<?php
include "config.php";
$error = "";

// get the id from the link edit_item.php?id=3
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// UPDATE : runs when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id       = (int) $_POST["id"];
    $name     = trim($_POST["name"]);
    $category = $_POST["category"];
    $price    = $_POST["price"];

    if ($name == "") {
        $error = "Item name is required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Price must be a number greater than 0.";
    } else {
        $stmt = $conn->prepare("UPDATE menu_items SET name = ?, category = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $category, $price, $id);
        $stmt->execute();
        header("Location: menu.php?msg=updated");
        exit();
    }
}

// READ the existing item to fill the form
$stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    die("Menu item not found. <a href='menu.php'>Back</a>");
}

$page_title = "Edit Menu Item";
include "header.php";
$categories = array("Starter", "Main Course", "Breakfast", "Dessert", "Beverage");
?>

<h2>Edit Menu Item</h2>

<?php if ($error != "") { ?>
    <div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post" action="edit_item.php">
    <input type="hidden" name="id" value="<?php echo $item["id"]; ?>">

    <label for="name">Item Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($item["name"]); ?>" required>

    <label for="category">Category</label>
    <select id="category" name="category">
        <?php foreach ($categories as $cat) { ?>
            <option <?php if ($cat == $item["category"]) echo "selected"; ?>><?php echo $cat; ?></option>
        <?php } ?>
    </select>

    <label for="price">Price (Rs.)</label>
    <input type="number" id="price" name="price" step="0.01" min="1" value="<?php echo $item["price"]; ?>" required>

    <button type="submit">Update Item</button>
</form>

<?php include "footer.php"; ?>
