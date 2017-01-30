
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/soon.min.css">
</head>
<body>

<div id="numbers" class="soon" data-face="slide up"></div>

<script src="/js/numbers.js"></script>
<script>
    var m = new Matrix({});
    document.getElementById('numbers').appendChild(m.getElement());
    var i = 403;
    setInterval(function () {
        i++;
        m.setValue(i);
    }, 1000);
</script>
</body>
</html>
