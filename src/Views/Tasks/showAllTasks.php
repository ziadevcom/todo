<?php include VIEWS_DIR . '/Fragments/Notice.php' ?>

<?php if (empty($tasks)): ?>

    <h1> No tasks found. <a href='/create-task'> Create one now </a>

    <?php else : ?>
        <h1 style="text-align:center">Here are your tasks<br></br></h1>
        <?php
        usort($tasks, fn($a, $b) => $a['completed'] <=> $b['completed'])
        ?>
        <div class="tasks">
            <?php foreach ($tasks as $task): ?>
                <?php
                $id = $task['id'];
                $title = $task['title'];
                $description = $task['description'];
                $completed = (bool) $task['completed'];
                ?>
                <article class="task<?= $completed ? ' completed' : '' ?>">
                    <h2><?= $title ?></h2>
                    <p><?= $description ?></p>
                    <small><b><?= $completed ? '✅ Task Completed' : '🕛 In Progress' ?></b></small>
                    <br>
                    <br>
                    <div>
                        <a role="button" href="/task/edit?id=<?= $id ?>">Edit</a>
                        <form action="/task/delete" method="POST">
                            <input type="hidden" name="taskId" value="<?= $id ?>">
                            <button class="red" type="submit">Delete</button>
                        </form>
                        <form action="/task/complete" method="POST">
                            <input type="hidden" name="taskId" value="<?= $id ?>">
                            <input type="hidden" name="task_status" value="<?= (int) !$completed ?>">
                            <button class="contrast" type="submit">
                                <?= $completed ? 'Mark as Incomplete' : 'Mark as Complete' ?>
                            </button>
                        </form>
                    </div>
                </article>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <style>
        .tasks button,
        .tasks a {
            width: 100% !important;
            font-size: 0.8rem !important;
            padding: 10px;
            margin-bottom: 1rem;
        }

        .task.completed {
            border-bottom: 4px solid green;
        }

        button.red {
            --pico-background-color: red;
            --pico-color: white;
            --pico-border-color: red;
        }

        .tasks {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }


        @media (max-width: 1300px) {
            .tasks {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1000px) {
            .tasks {
                grid-template-columns: 1fr;
            }
        }
    </style>