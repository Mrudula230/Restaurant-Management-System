<?php
include "config.php";

// DELETE : runs when the link menu.php?delete=3 is clicked
if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: menu.php?msg=deleted");
    exit();
}

$page_title = "Menu";
include "header.php";

// READ : get all menu items
$result = $conn->query("SELECT * FROM menu_items ORDER BY category, name");
?>

<h2>Menu</h2>

<?php if (isset($_GET["msg"]) && $_GET["msg"] == "deleted") { ?>
    <div class="success">Menu item deleted.</div>
<?php } ?>
<?php if (isset($_GET["msg"]) && $_GET["msg"] == "added") { ?>
    <div class="success">Menu item added.</div>
<?php } ?>
<?php if (isset($_GET["msg"]) && $_GET["msg"] == "updated") { ?>
    <div class="success">Menu item updated.</div>
<?php } ?>

<table>
    <tr>
        <th>ID</th><th>Name</th><th>Category</th><th>Price (Rs.)</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo htmlspecialchars($row["name"]); ?></td>
        <td><?php echo htmlspecialchars($row["category"]); ?></td>
        <td><?php echo number_format($row["price"], 2); ?></td>
        <td>
            <a class="edit" href="edit_item.php?id=<?php echo $row["id"]; ?>">Edit</a> |
            <a class="delete" href="menu.php?delete=<?php echo $row["id"]; ?>"
               onclick="return confirm('Delete this item?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<?php include "footer.php"; ?>
