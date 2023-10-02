

<!DOCTYPE html>
<html>
<head>
    <title>Group Members</title>
    <style>  body {
            font-family: Arial, sans-serif;
            font-size: 20px;
        }

        #calendarControls {
            margin-bottom: 20px;
        }

        button {
            font-size: 20px;
            padding: 10px 20px;
            margin: 5px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            width: 14.28%;
            text-align: center;
            padding: 20px 0;
            border: 1px solid #ddd;
        }

        td[data-date]:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .task {
            font-size: 14px;
            color:blue;
            background-color:#58b48b9a;
        }

        .task:hover {
            background-color: #3a8b68; /* ホバー時の背景色 */
        }
        .header-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f7f7f7;
    padding: 10px 0;
}

.header-buttons form {
    margin: 0 10px;
    width:100%;
}

.header-buttons button {
    padding: 10px 15px;
    cursor: pointer;
    width:100%;
}
ul {
    list-style-type: none;
}

</style>
</head>
<body>
<?php echo View::forge('header'); ?>
    <h1>メンバー</h1>
    <ul >
        
    
    <?php foreach($group_member as $member): ?>
<form method="post" action="/demo/hello/public/original/see_others/">
<button name="email" type="submit" style="margin-top:10px; display:flex;" value="<?php echo $member['email']; ?>">
            <li><?php echo $member['email']; ?></li>
    </button>
    
    <?php endforeach; ?>
    </ul>
</body>
</html>
