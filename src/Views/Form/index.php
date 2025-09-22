<?php

$action = $form['action'];
$fields = $form['fields'];
$submit = $form['submit'];
$method = $form['method'] ?? 'post';
$inlineErrorExists = isset($errors) && count($errors) > 0;
?>

<!-- Debug -->

<!-- <pre>
    <?= var_dump($completed) ?>
</pre> -->


<?php include VIEWS_DIR . '/Fragments/Notice.php' ?>

<!-- Form -->
<form action="<?= $action ?>" method="<?= $method ?>">
    <?php foreach ($fields as $field): ?>
        <?php
        $name = $field['name'];
        $label = $field['label'];
        $value = $field['value'];
        $type  = $field['type'];
        $error  = isset($errors) && array_key_exists($name, $errors) ? $errors[$name]  : null;
        $helperId = "$name-helper";
        $labelHTML = "<label for='$name'>$label</label>";
        ?>
        <fieldset>
            <?php if (in_array($type, ['text', 'password', 'number', 'email', 'hidden'])): ?>
                <?= $type !== 'hidden' ? $labelHTML : '' ?>
                <input
                    type="<?= $type ?>"
                    name=<?= $name ?>
                    id="<?= $name ?>"
                    placeholder=" Enter your <?= $name ?>"
                    value="<?= $value ?>"
                    aria-invalid="<?= isset($error)  ? "true" : "" ?>"
                    aria-describedby="<?= $helperId ?>">
            <?php elseif ($type === 'textarea'): ?>
                <?= $labelHTML ?>
                <textarea
                    name="<?= $name ?>"
                    id="<?= $name ?>"
                    placeholder="Enter value for <?= $name ?>"
                    aria-invalid="<?= isset($error)  ? "true" : "" ?>"
                    aria-describedby="<?= $helperId ?>"
                    rows="7"><?= $value ?></textarea>
            <?php elseif ($type === 'checkbox'): ?>
                <input
                    type="checkbox"
                    name="<?= $name ?>"
                    id="<?= $name ?>"
                    <?= $value ? 'checked' : '' ?>>
                <?= $labelHTML ?>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <small id="<?= $helperId ?>"><?= $error ?? '' ?></small>
            <?php endif; ?>

        </fieldset>
    <?php endforeach; ?>
    <input type="submit" value="<?= $submit ?>">
</form>

<style>
    .notice {
        --notice-color: green;
        padding: 1rem;
        background-color: var(--notice-color);
        color: black;
    }

    .notice p {
        color: white !important;
        margin: 0;
        text-align: center;
    }

    .notice.error {
        --notice-color: red;
    }
</style>