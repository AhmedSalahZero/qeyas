<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $new->getTitle() }}</title>
	<style>
	.info{
		font-size: 15px;
  line-height: 24px;
  color: #555;
  margin-bottom: 20px;
	}
	.mb-5{
		margin-bottom:1rem;
		
	}
	.news_content{
	max-width:60%;margin-left:auto;margin-right:auto;text-align:center	
	}
	</style>
</head>
<body>
	<div class="news_content " >
		<h2 class="mb-5">{{ $new->getTitle() }}</h2>
		<p class="info">{{ $new->newsDateApi }}</p>
		<img src="{{ $new->getImage() }}" alt="{{ $new->getTitle() }}">
		<p class="info">{!! $new->getDescription() !!}</p>
		<img src="{{ getLogo() }}">
		
	</div>
</body>
</html>
