<html lang="ch">
<head>
    <title>App Name - Page Title</title>
</head>
<body>

<h1>{{ title }}</h1>
<p>This is appended to the master sidebar.</p>

<div class="container">
    <p>This is my body content.</p>
	{% for item in list %}
    <a href="/new/{{ item['id'] }}">
        {{ item['title'] }}
    </a>
    <br/>
    {{ item['content'] }}
    {% endfor %}
    <br/>

    最新资讯：
    <br/>

    {% for new in news %}
    <a href="/new/{{ new['id'] }}">
        {{ new['title'] }}
    </a>
    <br/>
    {% endfor %}
</div>
</body>
</html>
