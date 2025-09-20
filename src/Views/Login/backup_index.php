

<!-- Notice -->
<?php if (isset($notice)): ?>
    <article class="notice <?= $notice['status']->value ?>">
        <p><?= $notice['message'] ?></p>
    </article>
<?php endif; ?>

<!-- Form -->
<form action="/login" method="post">
    <?php $inputs = [
        [
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
            'value' => $email ?? ''
        ],
        [
            'label' => 'Password',
            'type' => 'password',
            'name' => 'password',
            'value' => $password ?? ''
        ],
    ] ?>

    <?php foreach ($inputs as $input): ?>
        <?php
        $label  = $input['label'];
        $type   = $input['type'];
        $value  = $input['value'];
        $name   = $input['name'];
        $error  = isset($errors) && array_key_exists($name, $errors) ? $errors[$name]  : null;
        $helperId = "$name-helper";
        ?>

        <fieldset>
            <label for="<?= $name ?>"><?= $label ?></label>
            <input name="<?= $name ?>" type="<?= $type ?>" value="<?= $value ?>" aria-invalid="<?= isset($error)  ? "true" : "" ?>" aria-describedby="<?= $helperId ?>" />
            <?php
            if (isset($error)): ?>
                <small id="<?= $helperId ?>"><?= $error ?? '' ?></small>
            <?php endif; ?>
        </fieldset>

    <?php endforeach; ?>

    <input type="submit" value="Log in" />
    </div>


    <!-- Temp -->
    <div>
        <?php if (isset($data)): ?>
            <pre>
                <?php print_r($data) ?>
                <?php print_r($errors) ?>
            </pre>
        <?php endif; ?>
    </div>
</form>