<h3>Feedbacks:</h3>
<br/>

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
