<style>
    .notice {
        --notice-color: green;
        padding: 1rem;
        background-color: var(--notice-color);
        color: black;
    }

    .notice * {
        color: white !important;
        margin: 0;
        text-align: center;
    }

    .notice.error {
        --notice-color: #ff3232;
    }
</style>

<!-- Notice -->
<?php if (isset($notice)): ?>
    <article class="notice <?= $notice['status']->value ?>">
        <p><?= $notice['message'] ?> <a href="/login">Click here to login</a></p>
    </article>
<?php endif; ?>

<form action="/sign-up" method="post">
    <?php $inputs = [
        [
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
            'value' => $email ?? ''
        ],
        [
            'label' => 'Name',
            'type' => 'text',
            'name' => 'name',
            'value' => $name ?? ''
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
        $name   = $input['name'];
        $label  = $input['label'];
        $type   = $input['type'];
        $value  = $input['value'];
        $error  = isset($errors) && array_key_exists($name, $errors) ? $errors[$name]  : null;
        $helperId = "$name-helper";
        ?>

        <fieldset>
            <label for="<?= $name ?>"><?= $label ?></label>
            <input name="<?= $name ?>" type="<?= $type ?>" value="<?= $value ?>" aria-invalid="<?= $error  ? "true" : "" ?>" aria-describedby="<?= $helperId ?>" />
            <?php
            if ($error): ?>
                <small id="<?= $helperId ?>"><?= $error ?? '' ?></small>
            <?php endif; ?>
        </fieldset>

    <?php endforeach; ?>
    <input type="submit" value="Sign Up" />
    </div>


    <!-- Temp -->
    <!-- <div>
        <?php if (isset($data)): ?>
            <pre>
                <?php print_r($data) ?>
                <?php print_r($errors) ?>
            </pre>
        <?php endif; ?>
    </div> -->
</form>