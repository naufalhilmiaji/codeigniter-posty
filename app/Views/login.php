<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?></title>
</head>
<body>
    <?php echo session()->getFlashdata('login'); ?>
    <?php echo session()->getFlashdata('error'); ?>

    <form action="<?php echo base_url('/login') ?>" method="POST">
        <div>
            <label>Username: </label>
            <input type="email" name="email">
        </div>
        <br>
        <div>
            <label>Password: </label>
            <input type="password" name="password">
        </div>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>