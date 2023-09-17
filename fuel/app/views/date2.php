

<!DOCTYPE html>
<html>
<head>
    <title>Group Members</title>
</head>
<body>
    <h1>メンバー</h1>
    <ul>
        
    
    <?php foreach($group_member as $member): ?>
<form method="post" action="/demo/hello/public/original/see_others/">
<button name="email" type="submit" style="margin-top:10px; display:flex;" value="<?php echo $member['email']; ?>">
            <li><?php echo $member['email']; ?></li>
    </button>
    
    <?php endforeach; ?>
    </ul>
</body>
</html>
