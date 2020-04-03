<html lang="ch">
<head>
    <title>App Name - Page Title</title>
</head>
<body>

<h1><?= $this->title ?></h1>
<p>This is appended to the master sidebar.</p>

<div class="container">
    <p>This is my body content.</p>
    <?php foreach ($this->list as $item) : ?>
    <a href="/new/<?= $item['id'] ?>"><?= $item['title'] ?></a><br/>
    <?= $item['content'] ?>
    <?php endforeach; ?>

    <br/>

    最新资讯：
    <br/>
    <?php foreach ($this->news as $new) : ?>
    <a href="/new/<?= $new['id'] ?>"><?= $new['title'] ?></a><br/>
    <?php endforeach; ?>
</div>
</body>
</html>
