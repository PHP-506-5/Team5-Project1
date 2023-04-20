<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trip_header</title>
    <style>
/* 이미지 슬라이드 css */
* {
	margin:0;
	padding:0;
	box-sizing:border-box;
}
ul, li {
	list-style:none;
}
[name="slide"] {
	display:none;
}
.slidebox {
	max-width:1000px;
	width:100%;
	margin:0 auto;
	text-align:center;
}
.slidebox img {
	max-width:100%;
}
.slidebox .slidelist {
	white-space:nowrap;
	font-size:0;
	overflow:hidden;
}
.slidebox .slideitem {
	position:relative;
	display:inline-block;
	vertical-align:middle;
	width:100%;
	transition:all .30s;
}
.slidebox .slideitem label {
	position:absolute;
	z-index:1;
	top:50%;
	transform:translateY(-50%);
	padding:20px;
	border-radius:50%;
	cursor:pointer;
} */
/* 페이징 스타일 */
.paginglist {
	text-align:center;
	padding:30px 0;
}
.paginglist > li {
	display:inline-block;
	vertical-align:middle;
	margin:0 10px;
}
/* .paginglist > li > label {
	display:block;
	padding:10px 30px;
	border-radius:10px;
	background:#ccc;
	cursor:pointer;
}
.paginglist > li:hover > label {
	background:#333;
}
/* 시간변경 */
[id="slide01"]:checked ~ .slidelist .slideitem {transform:translateX(0);animation:slide01 20s infinite;}
[id="slide02"]:checked ~ .slidelist .slideitem {transform:translateX(-100%);animation:slide02 20s infinite;}
[id="slide03"]:checked ~ .slidelist .slideitem {transform:translateX(-200%);animation:slide03 20s infinite;}
[id="slide04"]:checked ~ .slidelist .slideitem {transform:translateX(-300%);animation:slide04 20s infinite;}
@keyframes slide01 {
	0% {left:0%;}
	23% {left:0%;}
	25% {left:-100%;}
	48% {left:-100%;}
	50% {left:-200%;}
	73% {left:-200%;}
	75% {left:-300%;}
	98% {left:-300%;}
	100% {left:0%;}
}
@keyframes slide02 {
	0% {left:0%;}
	23% {left:0%;}
	25% {left:-100%;}
	48% {left:-100%;}
	50% {left:-200%;}
	73% {left:-200%;}
	75% {left:100%;}
	98% {left:100%;}
	100% {left:0%;}
}
@keyframes slide03 {
	0% {left:0%;}
	23% {left:0%;}
	25% {left:-100%;}
	48% {left:-100%;}
	50% {left:200%;}
	73% {left:200%;}
	75% {left:100%;}
	98% {left:100%;}
	100% {left:0%;}
}
@keyframes slide04 {
	0% {left:0%;}
	23% {left:0%;}
	25% {left:300%;}
	48% {left:300%;}
	50% {left:200%;}
	73% {left:200%;}
	75% {left:100%;}
	98% {left:100%;}
	100% {left:0%;}
}
</style>
</head>
<body>
<!-- 이미지 슬라이드    -->
<div class="slidebox">
	<input type="radio" name="slide" id="slide01" checked>
	<input type="radio" name="slide" id="slide02">
	<input type="radio" name="slide" id="slide03">
	<input type="radio" name="slide" id="slide04">
	<ul class="slidelist">
		<li class="slideitem">
			<div>
				<label for="slide04" class="left"></label>
				<label for="slide02" class="right"></label>
				<a><img src="/image/img01.jpg"></a>
			</div>
		</li>
		<li class="slideitem">
			<div>
				<label for="slide01" class="left"></label>
				<label for="slide03" class="right"></label>
				<a><img src="/image/img02.jpg"></a>
			</div>
		</li>
		<li class="slideitem">
			<div>
				<label for="slide02" class="left"></label>
				<label for="slide04" class="right"></label>
				<a><img src="/image/img03.jpg"></a>
			</div>
		</li>
		<!-- <li class="slideitem">
			<div>
				<label for="slide03" class="left"></label>
				<label for="slide01" class="right"></label>
				<a><img src="../../사진/img0"></a> 
			</div>
		</li> -->
	</ul>
</div>
</body>
</html>