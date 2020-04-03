<html lang="ch">
<head>
    <title>App Name - Page Title</title>
</head>
<body>

<h1>{$title}</h1>
<p>This is appended to the master sidebar.</p>

<div class="container">
    <p>This is my body content.</p>
    {foreach $list as $item}
    <a href="/new/{$item['id']}">{$item['title']}</a><br/>
    {$item['content']}
    {/foreach}
    <br/>

    最新资讯：
    <br/>
    {foreach $news as $new}
    <a href="/new/{$new['id']}">{$new['title']}</a><br/>
    {/foreach}
</div>
</body>
</html>
