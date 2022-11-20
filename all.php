<?php use Model\Entry;
use Query\DateQuery;

require 'header.php';

$monthStart = new DateQuery(new DateTime('first day of this month'));

$entries = Entry::getAll($monthStart);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Величина</th>
            <th>Субъект</th>
            <th>Причина</th>
            <th>Категория</th>
            <th>Метки</th>
            <th>Настроение</th>
            <th>Дата</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($entries as $entry) { ?>
            <tr class="<?php echo $entry['type'] == 1 ? 'table-success' : 'table-warning'; ?>">
                <td><b><?php echo $entry['type'] == 1 ? '+' : '-'; ?> <?php echo $entry['value']; ?></b></td>
                <td><?=$entry['subject']?></td>
                <td><?=$entry['reason']?></td>
                <td><?=$entry['category']?->getName()?></td>
                <td><?php foreach ($entry['tags'] as $tag) {

                } ?></td>
                <td><?=$entry['mood']?></td>
                <td><?= (new DateTime($entry['date']))->format('d.m.Y') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require 'footer.php'; ?>