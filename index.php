<?php include 'db.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Book Inventory Management System</title>
    <a href="logout.php" style="float:right; margin: 20px;">Logout</a>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 70%; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        input[type="text"], input[type="email"], input[type="number"] { padding: 5px; width: 200px; }
        input[type="submit"] { padding: 5px 10px; margin-top: 5px; }
    </style>
</head>
<body>

<h2>Book Inventory</h2>

<?php
// ---------- ADD BOOK ----------
if (isset($_POST['add'])) {
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $conn->query("INSERT INTO books (book_title, author, category, price, quantity) VALUES ('$book_title', '$author', '$category', '$price', '$quantity')");
    echo "<meta http-equiv='refresh' content='0'>";
}

// ---------- FETCH BOOKS ----------
$result = $conn->query("SELECT * FROM books");

// ---------- DELETE BOOK ----------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id=$id");
    echo "<meta http-equiv='refresh' content='0'>";
}

// ---------- EDIT BOOK ----------
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM books WHERE id=$id");
    $data = $res->fetch_assoc();
}

// ---------- UPDATE BOOK ----------
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $conn->query("UPDATE books SET book_title='$book_title', author='$author', category='$category', price='$price', quantity='$quantity' WHERE id=$id");
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

<!-- ADD BOOK FORM -->
<h3>Add New Book</h3>
<form method="POST" action="">
    <input type="text" name="book_title" placeholder="Book Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <input type="submit" name="add" value="Add Book">
</form>

<!-- EDIT BOOK FORM (only show if editing) -->
<?php if (isset($data)): ?>
    <h3>Edit Book</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <input type="text" name="book_title" value="<?php echo $data['title']; ?>" required>
        <input type="text" name="author" value="<?php echo $data['author']; ?>" required>
        <input type="text" name="category" value="<?php echo $data['category']; ?>" required>
        <input type="number" name="price" value="<?php echo $data['price']; ?>" required>
        <input type="number" name="quantity" value="<?php echo $data['quantity']; ?>" required>
        <input type="submit" name="update" value="Update Book">
    </form>
<?php endif; ?>

<!-- BOOKS TABLE -->
<h3>Book List</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['book_title']; ?></td>
            <td><?= $row['author']; ?></td>
            <td><?= $row['category']; ?></td>
            <td><?= $row['price']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td>
                <a href="?edit=<?= $row['id']; ?>">Edit</a> |
                <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Delete this book?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>