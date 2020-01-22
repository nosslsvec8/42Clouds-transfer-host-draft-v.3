<!DOCTYPE html>
<html>
<head>
	<title>ver.2.0 перенос верстки с черновика на хост</title>
	<link rel="shortcut icon" href="product.png" type="image/png">
</head>
<body>
	<main>
		<h1>ver.2.0 перенос верстки с черновика на хост</h1>
		<div class="main-title">
			<h2>html</h2>
			<h2>css</h2>
		</div>
		<div class="main-panel">
			<div class="main-textarea">
				<textarea class="html" name="text" placeholder="Вставте ваш html i js код"></textarea>
				<textarea class="css" name="text" placeholder="Вставте ваш css код"></textarea>
			</div>
			<div class="main-control">
				<input type="submit" class="dev" name="select" value="Объединить для ext-dev" />
				<input type="submit" class="prod" name="select" value="Подготовить к переносу на prod" />
			</div>
		</div>
	</main>
	<section class="result">
		<h3>Результат</h3>
		<textarea class="result-code" id="code" name="text" placeholder="Результат.."></textarea>
	</section>
</body>
</html>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
	$('.prod').click(function(){
        
        var css = $(".css").val();
        css = '<style type="text/css">' + "\n" + css + "\n" + '</style>';

        var html = $(".html").val();
        var code = css + "\n" + html;
        $('.html').val('');

        var ajaxurl = 'main.php',
        data =  {'action': code, 'button': 'prod'};
        $.post(ajaxurl, data, function (response) {
            $('.html').val('');
            $('.html').val($.trim(response));
 
            var newHtml = $(".html").val();

            $('#code').val('');
        	$('#code').val($.trim(newHtml + '\n'));


        	var code = $("#code").val();
        	data =  {'action': code};
        	$.post(ajaxurl, data, function (response) {
	            $('#code').val($.trim(response));	        	
	        });
        });
	});

	$('.dev').click(function(){
        
        var css = $(".css").val();
        css = '<style type="text/css">' + "\n" + css + "\n" + '</style>';

        var html = $(".html").val();
        var code = css + "\n" + html;
        $('.html').val('');

        var ajaxurl = 'main.php',
        data =  {'action': code, 'button': 'dev'};
        $.post(ajaxurl, data, function (response) {
            $('.html').val('');
            $('.html').val($.trim(response));
 
            var newHtml = $(".html").val();

            $('#code').val('');
        	$('#code').val($.trim(newHtml + '\n'));


        	var code = $("#code").val();
        	data =  {'action': code};
        	$.post(ajaxurl, data, function (response) {
	            $('#code').val($.trim(response));	        	
	        });
        });
	});
</script>

<style type="text/css">
	main{
		text-align: center;
		padding-top: 0;
	}

	h2, h3{
		margin: 0.5em 0;
	}

	.main-panel{
		display: flex;
		justify-content: space-evenly;
		align-items: center;
		flex-direction: column;
	}

	.main-control{
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.main-textarea{
		display: flex;
	}

	.main-title{
		display: flex;
		justify-content: space-evenly;
	}

	textarea{
		width: 34vw;
    	height: 150px;
    	margin: 0 4% 30px;
	}

	input{
		margin: 0 3%;
		border: 0;
		border-radius: 20px;
		padding: 6px 18px;
		font-size: 15px;
	}

	input:hover{
		cursor: pointer;
	}

	.result{
		padding-top: 18px;
		text-align: center;
	}

	.dev{
		background-color: #57fa57;
	}

	.prod{
		background-color: yellow;
	}
</style>