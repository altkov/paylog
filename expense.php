<?php use Model\Category;
use Model\Expense;
use Model\Income;
use Query\DateQuery;

require 'header.php'; ?>

<h1>Траты:</h1>

<form action="expense.php" method="GET" class="col-md-8">
    <label class="form-label" for="date-start">
        С
    </label>
    <input type="date" class="form-control" name="date-start" id="date-start" value="<?php echo $_GET['date-start'] ?? ''; ?>">

    <label class="form-label" for="date-end">
        До
    </label>
    <input type="date" class="form-control" name="date-end" id="date-end" value="<?php echo $_GET['date-end'] ?? ''; ?>">

    <button class="btn btn-outline-primary">Фильтр</button>
</form>

<div class="row">
    <?php
    if (isset($_GET['date-start'])) {
        $start = DateTime::createFromFormat('Y-m-d', $_GET['date-start']);
        $end = DateTime::createFromFormat('Y-m-d', $_GET['date-end']);

        $interval = new DateQuery($start, $end);
        $diff = $start->diff($end);
        $days = $diff->days;

        $total = Expense::getSum($interval); ?>

        <div class="col-md-6">
            <h3>Всего потрачено</h3>
            <h2><?php echo $total; ?></h2>
            <hr>
        </div>
        <div class="col-md-6">
            <h3>В среднем в день</h3>
            <h2><?php echo round($total / $days);  ?></h2>
        </div>

        <?php

        $monthIncome = Income::getSum($interval);
        $monthExpense = Expense::getSum($interval);
        
        $categories = Category::getAll();
        $categoriesOutput = [];
        foreach ($categories as $category) {
            $categoriesOutput[] = [$category->getName(), $category->getTotalExpense($interval)];
        }
        ?>

        <script>
            const categories = JSON.parse('<?php echo json_encode($categoriesOutput); ?>');
            <?php
            $categoriesOutput[] = ['Остаток', $monthIncome - $monthExpense];
            ?>
            const categoriesWithRest = JSON.parse('<?php echo json_encode($categoriesOutput); ?>');
        </script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="assets/js/category-chart.js"></script>

        <div class="row">
            <div class="col-md-6">
                <div id="category-chart"></div>
            </div>
            <div class="col-md-6">
                <div id="category-chart-full"></div>
            </div>
        </div>
    <?php } ?>
</div>


<?php require 'footer.php'; ?>