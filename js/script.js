var step = 1;

function load_urls() {
	var JSONUrl = 'json/listar.php?step=' + step;
	$.getJSON( JSONUrl,
		function(r){
				console.log('Cargado JSON: ' + JSONUrl);
				for(x in r){
					var tmp = '<tr><td>' + r[x].index + '</td><td><a href="' + window.location.href + '' + r[x].id + '">' + window.location.href + '' + r[x].id + '</a></td><td><a href="' + r[x].url + '">' + r[x].url + '</a></td></tr>';
					$('#lister').append(tmp);
				}
				hasTargetBlank();
		}
	);
}

function refresh_urls() {
	step = 1;
	$('#lister').html('');
	$('#container').scrollTop(0);
	console.log('Clear');
	load_urls();
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

					refresh_urls();
					$('#url').val('');
					$('#qr').attr('src', 'apps/qr.php?s=http://dnn.im/' + res[1]);
					$('#elink, #qr').fadeIn();
				}else{
					if (res[1] == '1'){
						$('#newLink').attr('href', window.location.href + '' + res[2]).text( window.location.href + '' + res[2]);
						$('#url').val('');
						$('#qr').attr('src', 'apps/qr.php?s=http://dnn.im/' + res[2]);
						$('#elink, #qr').fadeIn();
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

function scroll_loaded() {
	var scrollpoint = ($('#lister').height() - $(window).height()) - 50,
		scrollpos = $('#container').scrollTop();

	if(scrollpos > scrollpoint) {
		step++;
		load_urls();
	}
}

function run () {
	$('#elink').hide();

/*	$('#elink').live('click', function(e){
		e.preventDefault();
		var elink = $(this).attr('href');
		window.clipboardData.setData("Dannegm Shorter", elink);
	}); /**/

	$('#shorter').click(function(e){
		e.preventDefault();
		shorter();
	});
	refresh_urls();

	$('#container').scroll(scroll_loaded);
}
$(document).ready(run);