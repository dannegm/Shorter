var step = 1;

function load_urls() {
	var JSONUrl = 'json/listar.php?step=' + step;
	$.getJSON( JSONUrl,
		function(r){
			$('#lister').html('')
			console.log('Cargado JSON: ' + JSONUrl);
			for(x in r){
				var tmp = '<tr><td>' + r[x].index + '</td><td><a href="' + window.location.href + '' + r[x].id + '">' + window.location.href + '' + r[x].id + '</a></td><td><a href="' + r[x].url + '">' + r[x].url + '</a></td></tr>';
				$('#lister').append(tmp);
			}
			hasTargetBlank();
		}
	);
}

function shorter() {
	$('#exist').css({'display':'none'});
	if ($('#url').val() == ''){
		alert('Error: debes escribir una direciión válida');
	}else{
		$.post(
			'apps/shorter.php',
			{
				'do': 'it',
				'url': $('#url').val()
			},
			function(r){
				var res = r.split(':');
				if(res[0]=='1'){
					$('#newLink').attr('href', window.location.href + '' + res[1]).text( window.location.href + '' + res[1]);

					load_urls();
					$('#url').val('')
					$('#elink').fadeIn();
				}else{
					if (res[1] == '1'){
						$('#newLink').attr('href', window.location.href + '' + res[2]).text( window.location.href + '' + res[2]);
						$('#url').val('')
						$('#elink').fadeIn();
						$('#exist').css({'display':'block'});
					}else{
						alert('Error: ' + res[1]);
					}
				}
			}
		);
	}
}

function hasTargetBlank () {
	$('a').attr('target', '_blank');
}

function pagin (action){
	switch(action){
		case 'back':
			step = step -1;
			load_urls();
			break;
		case 'next':
			step = step +1;
			load_urls();
			break;
	}
}

function run () {
	$('#elink').hide();

	$('#shorter').click(function(e){
		e.preventDefault();
		shorter();
	});
	load_urls();

	$('#back').click(function(e){ e.preventDefault(); pagin('back'); });
	$('#next').click(function(e){ e.preventDefault(); pagin('next'); });
}
$(document).ready(run);