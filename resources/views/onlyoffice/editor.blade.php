<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Editor</title>
</head>

<body style="height: 100%;">
    <div id="placeholder"></div>
    <script src="http://3.84.11.173/web-apps/apps/api/documents/api.js"></script>
    <script type="text/javascript">
        var config = @json( $config );
        var docEditor = new DocsAPI.DocEditor("placeholder", config);
    </script>
</body>

</html>
