<?php include VIEWS_DIR . '/Fragments/Notice.php' ?>

<?php if (empty($tasks)): ?>

    <h1> No tasks found. <a href='/create-task'> Create one now </a>

    <?php else : ?>
        <h1 style="text-align:center">Here are your tasks<br></br></h1>
        <div class="tasks">
            <?php foreach ($tasks as $task): ?>
                <?php
                $id = $task['id'];
                $title = $task['title'];
                $description = $task['description'];
                $completed = (bool) $task['completed'];
                ?>
                <article class="task">
                    <h2><?= $title ?></h2>
                    <p><?= $description ?></p>
                    <small><b><?= $completed ? '✅ Task Completed' : '🕛 In Progress' ?></b></small>
                    <br>
                    <br>
                    <div role="group">
                        <button>Edit</button>
                        <form action="/task/delete" method="POST">
                            <input type="hidden" name="taskId" value="<?= $id ?>">
                            <!-- <input type='submit' class="red" value="Delete"> -->
                            <button class="red"="submit">Delete</button>
                        </form>

                    </div>
                </article>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <style>
        button.red {
            --pico-background-color: red;
            --pico-color: white;
            --pico-border-color: red;
            width: 100% !important;
        }

        .tasks {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
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