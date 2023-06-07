<html>
<body>
    <h1>配列情報の標準</h1>

    <table>
        <?php foreach($members as $member): ?>
            <tr>
                <td><?php echo $member['name']; ?></td>
                <td><?php echo $member['age']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>


</body>
</html>