<h3>Surgical Videos:</h3>
<br/>
<?php if(isset($result)): ?>
    <table border="1" width="100%">
        <thead>
            <tr>
            <?php foreach ($fields as $key=>$value): ?>
                <th><?php echo $value; ?></th>
            <?php endforeach; ?>    
            </tr>
        </thead>
        <tbody>
        <?php foreach ($result->result_array() as $row): ?>
            <tr>
            <?php foreach ($fields as $key=>$value): ?>
                <td><?php echo $row[$value]; ?></td>
            <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No results matched.</p>
<?php endif ;?>