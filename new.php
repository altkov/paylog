<?php

use Model\Category;
use Model\Tag;

require 'header.php'; ?>

<form action="api/create.php" method="POST" class="col-md-8">
    <label class="form-label" for="value">
        Сумма
    </label>
    <input type="text" class="form-control" placeholder="0 Р." name="value" id="value">

    <label class="form-label" for="subject">
        Субъект
    </label>
    <input type="text" class="form-control" name="subject" id="subject">


    <label class="form-label" for="reason">
        Причина
    </label>
    <input type="text" class="form-control" name="reason" id="reason">

    <br>
    Тип

    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="0" id="type-0" checked>
        <label class="form-check-label" for="type-0">
            Расход
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="1" id="type-1">
        <label class="form-check-label" for="type-1">
            Доход
        </label>
    </div>

    <label class="form-label" for="category">
        Категория
    </label>
    <select name="category" id="category" class="form-control">
        <?php foreach (Category::getAll() as $category) { ?>
            <option value="<?php echo $category->getID(); ?>"><?php echo $category->getName(); ?></option>
        <?php } ?>
    </select>

    <label class="form-label" for="date">
        Дата
    </label>
    <input type="date" class="form-control" name="date" id="date">

    <br>
    Настроение
    <label><input type="radio" name="mood" value="0">Плохо</label>
    <label><input type="radio" name="mood" value="1">Так себе</label>
    <label><input type="radio" name="mood" value="2" checked>Ок</label>
    <label><input type="radio" name="mood" value="3">Хорошо</label>
    <label><input type="radio" name="mood" value="4">Отлично</label>

    <div class="col mt-4">
        <?php
        foreach (Tag::getAll() as $tag) {
            $id = $tag->getID();
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $id; ?>" id="tag-<?php echo $id; ?>">
                <label class="form-check-label" for="tag-<?php echo $id; ?>">
                    <?php echo $tag->getName(); ?>
                </label>
            </div>
        <?php }
        ?>
    </div>

    <hr>
    <button class="btn btn-outline-primary">Добавить</button>


</form>

    <div class="">
        <a href="/" class="btn btn-link">Назад</a>
    </div>

<?php require 'footer.php'; ?>