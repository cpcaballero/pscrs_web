<h3>Tech News:</h3>
<br/>
<?php if(isset($result)): ?>
    <?php foreach ($result->result_array() as $row): ?>
        <table border="1" width="100%">
            <?php foreach ($fields as $key=>$value): ?>
                <tr>
                    <td width="20%"><?php echo $value; ?></td>
                    <td><?php echo $row[$value]; ?></td>
                </tr>
            <?php endforeach; ?>    
        </table>
    <hr />
    <br />
    <?php endforeach; ?>
<?php else: ?>
    <p>No results matched.</p>
<?php endif ;?>
