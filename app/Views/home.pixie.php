<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link href="@favicon@" rel="shortcut icon" />
	<link href="@css_link(styles)" rel="stylesheet" />
</head>

<body>
	<div class="bg-slate-100 min-h-screen p-10">
		<div class="flex justify-center">
			<div class="font-mono border border-gray-400 text-sm text-center text-gray-900 bg-white p-2 rounded-md">Get
				started by editing <b>app/Views/home.pixie.php</b></div>
		</div>
		<div class="h-[50vh] flex justify-center items-center">
			<img src="@img_src(brand.png)" class="w-80 h-auto" />
		</div>
		<div class="flex justify-between gap-10 flex-col md:flex-row lg:px-16">
			<div
				class="flex flex-col gap-2 rounded-lg p-4 transition-colors hover:bg-slate-200 hover:border-b-2 hover:border-b-slate-400">
				<a href="https://github.com/mhs003/ElevateX-docs/blob/main/README.md"
					class="text-lg font-bold hover:underline">Docs</a>
				<p>Find-in depth information about ElevateX features</p>
			</div>
			<div
				class="flex flex-col gap-2 rounded-lg p-4 transition-colors hover:bg-slate-200 hover:border-b-2 hover:border-b-slate-400">
				<a href="https://github.com/mhs003/ElevateX-docs/blob/main/README.md"
					class="text-lg font-bold hover:underline">Learn</a>
				<p>Learn about ElevateX and try building great apps.</p>
			</div>
			<div
				class="flex flex-col gap-2 rounded-lg p-4 transition-colors hover:bg-slate-200 hover:border-b-2 hover:border-b-slate-400">
				<a href="https://github.com/mhs003/ElevateX-docs/blob/main/Examples.md"
					class="text-lg font-bold hover:underline">Examples</a>
				<p>See some example apps built using ElevateX framework.</p>
			</div>
			<div
				class="flex flex-col gap-2 rounded-lg p-4 transition-colors hover:bg-slate-200 hover:border-b-2 hover:border-b-slate-400">
				<a href="https://github.com/mhs003/ElevateX" class="text-lg font-bold hover:underline">Source</a>
				<p>Fully open-source project. Collaborate with me or make a pull request.</p>
			</div>
		</div>
	</div>
</body>

</html>