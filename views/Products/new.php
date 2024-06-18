<h1>New Product</h1>

<form action="/products/create" method="post">
    <label for="name">Name</label>
    <input type="text" id="name" name="name">

    <?php if (isset($errors["name"])) : ?>
        <p><?= $errors["name"] ?></p>
    <?php endif ?>
    <label for="description">Description</label>
    <textarea name="description" id="description">

    </textarea>
    <button>Save</button>
</form>