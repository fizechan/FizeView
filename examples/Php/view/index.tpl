<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>测试PHP原生模板引擎</title>
</head>
<body>
    <h1>你能看到下面的文字吗？</h1>
    <h1><?php echo $name ?></h1>

    <?php require_once 'footer.tpl'; ?>

    <?php require_once 'sub/footer.tpl'; ?>
</body>
</html>
