<html lang="ch">
<head>
    <title>App Name - Page Title</title>
</head>
<body>

<h1>{{ $title }}</h1>
<p>This is appended to the master sidebar.</p>

<div class="container">
    <p>This is my body content.</p>
	{{ BEGIN list }}
    <a href="/new/{{ $id }}">
        {{ $title }}
    </a>
    <br/>
    {{ $content }}
    {{ END }}
    <br/>

    最新资讯：
    <br/>

    {{ BEGIN news }}
    <a href="/new/{{ $id }}">
        {{ $title }}
    </a>
    <br/>
    {{ END }}
</div>
</body>
</html>
