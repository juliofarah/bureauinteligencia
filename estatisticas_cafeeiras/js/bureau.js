// Guarda os campos selecionados
var data = {
	'subgrupo': [],
	'tipo': [],
	'variedade': [],
	'origem': [],
	'destino': [],
	'fonte': [],
	'ano': []
}

$(document).ready(function(){
	// Esconde o conteúdo das abas
	$('.tabcontent').hide();
        
        $('body').ajaxStart(function(){
            $(this).css("cursor", "wait");
        }).ajaxStop(function(){
            $(this).css("cursor", "default");
        });
	
	$.getJSON('../datacenter/param', {type: "Groups"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#grupo .options ul').append('<li id="'+param.id+'">'+param.name+'</li>');
			});
			
			$('#variedade .options, #tipo .options, #origem .options, #destino .options, #fonte .options').slimScroll({
				height: $('#grupo .options').height() + $('#periodo').height() + 20
			});
			
			$('#subgrupo .options').slimScroll({
				height: $('#grupo .options').height(),
				alwaysVisible: true
			});
			
			/* Exibe os subgrupos */
			$('#grupo .options ul li').each(function(){
				$('#subgrupo .options').append('<ul id="dogrupo-'+$(this).attr('id')+'" class="subgroup"></ul>');
				
				var sg = $(this).html();
				var id = $(this).attr('id');
				$.getJSON('../datacenter/param', {type: "subgroup", id: $(this).attr('id')},
					function(data){
						$('#subgrupo .options ul#dogrupo-'+id).append('<li class="sg">'+sg+'</li>');
						$(data).each(function(i, param){
							$('#subgrupo .options ul#dogrupo-'+id).append('<li id="'+param.id+'">'+param.name+'</li>');
						});
					});
			});
			
			/* Exibe as fontes */
			$('#grupo .options ul li').each(function(){
				$('#fonte .options').append('<ul id="dogrupo-'+$(this).attr('id')+'" class="subgroup"></ul>');
				
				var sg = $(this).html();
				var id = $(this).attr('id');
				$.getJSON('../datacenter/param', {type: "font", id: $(this).attr('id')},
					function(data){
						$('#fonte .options ul#dogrupo-'+id).append('<li class="sg">'+sg+'</li>');
						$(data).each(function(i, param){
							$('#fonte .options ul#dogrupo-'+id).append('<li id="'+param.id+'">'+param.name+'</li>');
						});
					});
			});
		});
	
	$.getJSON('../datacenter/param', {type: "Variety"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#variedade .options ul').append('<li id="'+param.id+'">'+param.name+'</li>');
			});
		});
	
	$.getJSON('../datacenter/param', {type: "CoffeType"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#tipo .options ul').append('<li id="'+param.id+'">'+param.name+'</li>');
			});
		});
	
	$.getJSON('../datacenter/param', {type: "origin"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#origem .options ul').append('<li id="'+param.id+'">'+param.name+'</li>');
			});
		});
		
	$.getJSON('../datacenter/param', {type: "destiny"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#destino .options ul').append('<li id="'+param.id+'">'+param.name+'</li>');
			});
		});
	
	/*var dates = $( "#from, #to" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 3,
				dateFormat: "dd/mm/yy",
				onSelect: function( selectedDate ) {
					var option = this.id == "from" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
			});*/
	
	year = new Date();
	for (i = 1980; i <= year.getFullYear(); i++) {
		$('#de').append('<option value="'+i+'" '+(i == 1990 ? 'selected=""' : '')+'>'+i+'</option>');
		$('#ate').append('<option value="'+i+'" '+(i == year.getFullYear() ? 'selected=""' : '')+'>'+i+'</option>');
	}
	
	$('.options ul li').live('click', function(){
		if ($(this).is('.sg')) {return false;}
		if ($(this).is('.sel')) {
			$(this).removeClass('sel');
			$(this).css('background', 'none');
		} else {
			if ($(this).parents('.selector').attr('id') != 'origem'
				&& $(this).parents('.selector').attr('id') != 'destino'
				&& $(this).parents('.selector').attr('id') != 'fonte'
				&& $(this).html() != 'Todos'
				&& $(this).html() != 'Todas'
				&& $(this).parents('.options').find('.sel').length == 2) {
				alert("Você pode selecionar no máximo 2 campos");
			} else {
				// Se a opção selecionada for Todos, desmarca as outras opções
				if ($(this).html() == 'Todos' || $(this).html() == 'Todas') {
					$(this).parents('ul').find('li').removeClass('sel').css('background', 'none');
				} else {
					// Senão, procura por uma opção todos marcada
					$(this).parents('ul').find("li:contains('Todos'), li:contains('Todas')").removeClass('sel').css('background', 'none');
				}
				$(this).addClass('sel');
				$(this).css('background', '#eee');
			}
		}
	});
	
	/* Quando clica em um grupo exibe o subgrupo e a fonte */
	$('#grupo .options ul li').live('click', function(){
		$('#subgrupo .options ul').hide();
		$('#fonte .options ul').hide();
		$('#grupo .options ul li.sel').each(function(){
			$('#subgrupo .options ul#dogrupo-'+$(this).attr('id')).show();
			$('#fonte .options ul#dogrupo-'+$(this).attr('id')).show();
		});
	});
	
	$("#tabs ul li").click(function(){
		$("#tabs ul li").removeClass('sel');
		$(this).addClass('sel');
		$('.tabcontent').hide();
		$('#content-'+$(this).attr('id').replace('tab-', '')).show();
	});
	
	$('#tab-1').click(function(){
		if ($('#content-1').html() == '') {
			$.getJSON('../datacenter/table', data,
				function(tables){
					$(tables.tabela).each(function(i, table){
						$('#content-1').append(montaTabela(table));
					});
				});
		}
	});
	
	$('#tab-2').click(function(){
		if ($('#content-2').html() == '') {
			$.getJSON('../datacenter/chart', data,
				function(chart){
					mostraGrafico(chart);
				});
		}
	});
	
	$('.confirmar').click(function(){
		data = {
			'subgrupo': [],
			'tipo': [],
			'variedade': [],
			'origem': [],
			'destino': [],
			'fonte': [],
			'ano': []
		}
		
		// Pega os campos que foram selecionados
		if ($('#subgrupo .options li.sel').length > 1) {
			$('#subgrupo .options li.sel').each(function(){
				data.subgrupo.push($(this).attr('id'));
			});
		} else {
			data.subgrupo = $('#subgrupo .options li.sel').attr('id');
		}
		
		if ($('#tipo .options li.sel').length > 1) {
			$('#tipo .options li.sel').each(function(){
				data.tipo.push($(this).attr('id'));
			});
		} else {
			data.tipo = $('#tipo .options li.sel').attr('id');
		}
		
		if ($('#variedade .options li.sel').length > 1) {
			$('#variedade .options li.sel').each(function(){
				data.variedade.push($(this).attr('id'));
			});
		} else {
			data.variedade = $('#variedade .options li.sel').attr('id');
		}
		
		if ($('#origem .options li.sel').length > 1) {
			$('#origem .options li.sel').each(function(){
				data.origem.push($(this).attr('id'));
			});
		} else {
			data.origem = $('#origem .options li.sel').attr('id');
		}
		
		if ($('#destino .options li.sel').length > 1) {
			$('#destino .options li.sel').each(function(){
				data.destino.push($(this).attr('id'));
			});
		} else {
			data.destino = $('#destino .options li.sel').attr('id');
		}
		
		if ($('#fonte .options li.sel').length > 1) {
			$('#fonte .options li.sel').each(function(){
				data.fonte.push($(this).attr('id'));
			});
		} else {
			data.fonte = $('#fonte .options li.sel').attr('id');
		}
		
		data.ano = [$('#de').val(), $('#ate').val()];
		
		if (data.subgrupo == undefined
			|| data.tipo == undefined
			|| data.variedade == undefined
			|| data.origem == undefined
			|| data.destino == undefined
			|| data.fonte == undefined
			|| data.ano == undefined) {
			
			alert('É necessário selecionar todos os campos.');
				
		}
		
		$('.tabcontent').html('');
		
		if ($('#tab-1.sel').length == 1) {
			// Tabela
			$.getJSON('../datacenter/table', data,
				function(tables){
					$(tables.tabela).each(function(i, table){
						$('#content-1').append(montaTabela(table));
					});
				});
		} else if ($('#tab-2.sel').length == 1) {
			// Grafico
			$.getJSON('../datacenter/chart', data,
				function(chart){
					mostraGrafico(chart);
				});
		} else if ($('#tab-3.sel').length == 1) {
			// Excel
		} else if ($('#tab-4.sel').length == 1) {
			// Estatísticas
		}
		
		// Verifica qual aba esta aberta
		
		// Requisita
		
		return false;
	});
	
	// Mostra a primeira aba
	$('.tab:first').trigger('click');
	
});

function montaTabela(json) {
	table = '<table id="datatable">';

	table += '        <thead>';
	table += '	            <tr>';
	$(json.thead).each(function(i, column){
		table += '                <th scope="col">'+column.th+'</th>';
	});
	table += '            </tr>';
	table += '        </thead>';

	table += '        <tbody>';
	 
	$(json.tbody).each(function(i, column){
		table += '            <tr>'; 
		table += '                <td>'+column.variety+'</td>';
		
		table += '                <td>'+column.type+'</td>';
		
		table += '                <td>'+column.origin+'</td>';
		
		table += '                <td>'+column.destiny+'</td>';
		
		$(column.values).each(function(i, value){
			table += '                <td>'+value.value+'</td>';
		});
		table += '            </tr>';
	});
	
	table += '        </tbody>'  

	table += '</table>';
	
	return table;
}

function mostraGrafico(json) {
	$('#content-2').html('<div id="grafico"></div>');
	if (json.status == false) {
		alert('Houve um problema na geração do gráfico: ' + json.message);
	} else {
		var myChart = new FusionCharts( "fusion/"+json.typeChart, "myChartId", "730", "413", "0", "1" );
		myChart.setDataXML(json.chart);
		myChart.render("grafico");
	}
}