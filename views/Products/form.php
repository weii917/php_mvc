<label for="name">Name</label>
<input type="text" id="name" name="name" value="<?= $product["name"] ?? "" ?>">

<?php if (isset($errors["name"])) : ?>
    <p><?= $errors["name"] ?></p>
<?php endif ?>
<label for="description">Description</label>
<textarea name="description" id="description">
<?= $product["description"] ?? "" ?>
</textarea>
<button>Save</button>