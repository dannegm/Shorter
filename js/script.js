var step = 1;

function load_urls() {
	$.getJSON(
		'json/listar.php?step=' + step,
		function(r){
			$('#lister').html('')
			console.log('Cargado JSON: json/listar.php');
			console.log('- Contenido: ' + r);
			for(x in r){
				var tmp = '<tr><td>' + r[x].index + '</td><td><a href="' + window.location.href + 'go/' + r[x].id + '">' + window.location.href + 'go/' + r[x].id + '</a></td><td><a href="' + r[x].url + '">' + r[x].url + '</a></td></tr>';
				$('#lister').append(tmp);
			}
			hasTargetBlank();
		}
	);
}

function shorter() {
	$.post(
		'apps/shorter.php',
		{
			'do': 'it',
			'url': $('#url').val()
		},
		function(r){
			var res = r.split(':');
			if(res[0]=='1'){
				$('#newLink').attr('href', window.location.href + 'go/' + res[1]).text( window.location.href + 'go/' + res[1]);

				var tmp = '<tr style="font-size: 18px"><td>?</td><td><a href="' + window.location.href + 'go/' + res[1] + '">' + window.location.href + 'go/' + res[1] + '</a></td><td><a href="' + $('#url').val() + '">' + $('#url').val() + '</a></td></tr>';
				var tr1 = $('tr')[1];
				$(tmp).insertBefore(tr1);

				$('#url').val('');
				hasTargetBlank();

				$('#elink').fadeIn();
			}else{
				alert('Ha ocurrido un error: ' + r);
			}
		}
	);
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