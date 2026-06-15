<html lang="ch">
<head>
    <title>App Name - Page Title</title>
</head>
<body>

<h1>This is the master sidebar.</h1>
<p>This is appended to the master sidebar.</p>

<div class="container">
    <p>This is my body content.</p>

    {list}
    <a href="/new/{id}">{title}</a><br/>
    {content}
    {/list}

    <br/>

    最新资讯：
    <br/>
    {news}
    <a href="/new/{id}">{title}</a><br/>
    {/news}
</div>
</body>
</html>
