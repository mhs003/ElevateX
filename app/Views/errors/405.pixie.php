<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - @{{ $message }}</title>
	<link href="@favicon@" rel="shortcut icon" />
	<link href="@css_link(styles)" rel="stylesheet" />
</head>
<body>
    <div class="bg-slate-100 h-screen flex justify-center items-center gap-4 px-14">
        <div class="text-xl text-gray-900 font-bold">405</div><div class="h-14 w-[1px] bg-gray-800"></div><div class="text-gray-800">@{{ $message }}</div>
    </div>
</body>
</html>