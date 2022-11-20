<?php

use Model\Category;
use Model\Income;
use Model\Expense;
use Query\DateQuery;

require 'header.php';
$monthStart = new DateQuery(new DateTime('first day of this month'));
$weekStart = new DateQuery(new DateTime('monday this week'));

$monthIncome = Income::getSum($monthStart);
$monthExpense = Expense::getSum($monthStart);

$categories = Category::getAll();
$categoriesOutput = [];
foreach ($categories as $category) {
    $categoriesOutput[] = [$category->getName(), $category->getTotalExpense($monthStart)];
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
        <h3>Доходы за месяц</h3>
        <h2><?php echo $monthIncome ?></h2>
        <hr>
        <h3>За неделю</h3>
        <h2><?php echo Income::getSum($weekStart); ?></h2>
    </div>
    <div class="col-md-6">
        <h3>Расходы за месяц</h3>
        <h2><?php echo $monthExpense; ?></h2>
        <hr>
        <h3>За неделю</h3>
        <h2><?php echo Expense::getSum($weekStart); ?></h2>
    </div>
</div>

<a href="all.php" class="btn btn-link">Все записи</a>

<div class="row">
    <div class="col-md-6">
        <div id="category-chart"></div>
    </div>
    <div class="col-md-6">
        <div id="category-chart-full"></div>
    </div>
</div>


<a href="new.php" class="btn btn-primary btn-lg">Добавить запись</a>

<?php require 'footer.php'; ?>
