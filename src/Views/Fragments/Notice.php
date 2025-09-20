<!-- Notice -->
<?php if (isset($inlineErrorExists) && !$inlineErrorExists && isset($notice)): ?>
    <article class="notice <?= $notice['status']->value ?>">
        <p><?= $notice['message'] ?></p>
    </article>
<?php endif; ?>