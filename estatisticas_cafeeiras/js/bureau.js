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

// Guarda se há requests
var requests = new Array();

$(document).ready(function(){
    
	$('body').append('<div id="advise"><p>Aviso aqui!</p><a class="ok" href="#ok" style="float:none;">Ok</a></div>');
	$('#advise a').click(function(){
		$('#advise').hide();
		return false;
	});
	
	/* EXIBE O LOADING... A CADA REQUEST */
	$('body').append('<div id="loading">Carregando...</div>');
	
	$('#loading').ajaxStart(function(){
		requests.push(true);
		$(this).show();
	});

	$('#loading').ajaxStop(function(){
		requests.pop();
		if (requests[0] != true) {
			$(this).hide();
		}
	});
	/* FIM DO LOADING */

	// Esconde o conteúdo das abas
	$('.tabcontent').hide();
        
        // Pequeno evento de load - temporário
        $('body').ajaxStart(function(){
            $(this).css("cursor","wait");
        }).ajaxStop(function(){
            $(this).css("cursor","default");
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
						$('#fonte .options ul#dogrupo-'+id).append('<li id="all">Todos</li>');
					});
			});
		});
	
	$.getJSON('../datacenter/param', {type: "Variety"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#variedade .model ul').append('<li id="'+param.id+'">'+param.name+'</li>').hide();
			});
		});
	
	$.getJSON('../datacenter/param', {type: "CoffeType"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#tipo .model ul').append('<li id="'+param.id+'">'+param.name+'</li>').hide();
			});
		});
	
	$.getJSON('../datacenter/param', {type: "origin"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#origem .model ul').append('<li id="'+param.id+'">'+param.name+'</li>').hide();
			});
			$('#origem .model ul').append('<li id="all">Todos</li>');
		});
		
	$.getJSON('../datacenter/param', {type: "destiny"},//, id: null},
		function(data){
			$(data).each(function(i, param){
				$('#destino .model ul').append('<li id="'+param.id+'">'+param.name+'</li>').hide();
			});
			$('#destino .model ul').append('<li id="all">Todos</li>');
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
		if ($(this).parents('ul').hasClass('nosel')) return false;
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
				advise("Você pode selecionar no máximo 2 campos");
			} else {
				// Se a opção selecionada for Todos, desmarca as outras opções
				if ($(this).html() == 'Todos' || $(this).html() == 'Todas') {
					$(this).parents('ul').find('li.sel').removeClass('sel').css('background', 'none');
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
		
		if ($(this).hasClass('sel')) {
			$('#origem .options').append($('#origem .model ul').clone().attr('id', 'ordogrupo-'+$(this).attr('id')).
			prepend('<li class="sg">'+$(this).html()+'</li>').show());
			$('#destino .options').append($('#destino .model ul').clone().attr('id', 'dedogrupo-'+$(this).attr('id')).
			prepend('<li class="sg">'+$(this).html()+'</li>').show());
		} else {
			$('#origem #ordogrupo-'+$(this).attr('id')).remove();
			$('#destino #dedogrupo-'+$(this).attr('id')).remove();
			
			group = $(this).html()
			
			$('#subgrupo .options ul').each(function(){
				if ($(this).find('.sg').html() == group) {
					$(this).find('li.sel').trigger('click');
				}
			});
			
		}
	});
	
	$('#subgrupo .options ul li').live('click', function(){
		if ($(this).hasClass('sel')) {
			$('#variedade .options').append($('#variedade .model ul').clone().attr('id', 'dosubgrupo-'+$(this).attr('id')).
			prepend('<li class="sg">'+$(this).html()+'</li>').show());
			$('#tipo .options').append($('#tipo .model ul').clone().attr('id', 'dosubgrupo-'+$(this).attr('id')).
			prepend('<li class="sg">'+$(this).html()+'</li>').show());
		} else {
			$('#variedade #dosubgrupo-'+$(this).attr('id')).remove();
			$('#tipo #dosubgrupo-'+$(this).attr('id')).remove();
		}
	});
	
	$('#origem .options ul li').live('click', function(){
		if ($(this).parents('ul').find('.sel').length > 0) {
			if ($(this).parents('ul').find('.sg').html() == 'Oferta'
			 || $(this).parents('ul').find('.sg').html() == 'Demanda'
			 || $(this).parents('ul').find('.sg').html() == 'Indicadores Econômicos') {
				$('#destino #'+$(this).parents('ul').attr('id').replace('ordogrupo', 'dedogrupo')).addClass('nosel');
			}
		} else {
			if ($(this).parents('ul').find('.sg').html() == 'Oferta'
			 || $(this).parents('ul').find('.sg').html() == 'Demanda'
			 || $(this).parents('ul').find('.sg').html() == 'Indicadores Econômicos') {
				$('#destino #'+$(this).parents('ul').attr('id').replace('ordogrupo', 'dedogrupo')).removeClass('nosel');
			}
		}
	});
	
	$('#destino .options ul li').live('click', function(){
		if ($(this).parents('ul').find('.sel').length > 0) {
			if ($(this).parents('ul').find('.sg').html() == 'Oferta'
			 || $(this).parents('ul').find('.sg').html() == 'Demanda'
			 || $(this).parents('ul').find('.sg').html() == 'Indicadores Econômicos') {
				$('#origem #'+$(this).parents('ul').attr('id').replace('dedogrupo', 'ordogrupo')).addClass('nosel');
			}
		} else {
			if ($(this).parents('ul').find('.sg').html() == 'Oferta'
			 || $(this).parents('ul').find('.sg').html() == 'Demanda'
			 || $(this).parents('ul').find('.sg').html() == 'Indicadores Econômicos') {
				$('#origem #'+$(this).parents('ul').attr('id').replace('dedogrupo', 'ordogrupo')).removeClass('nosel');
			}
		}
	});
	
	/*$('#variedade .options ul li').live('click', function(){
		if ($(this).hasClass('sel')) {
			$('#tipo .options').append($('#tipo .model ul').clone().attr('id', 'devariedade-'+$(this).attr('id')).
			prepend('<li class="sg">'+$(this).html()+'</li>').show());
		} else {
			$('#devariedade-'+$(this).attr('id')).remove();
		}
	});*/
	
	$("#tabs ul li").click(function(){
		$("#tabs ul li").removeClass('sel');
		$(this).addClass('sel');
		$('.tabcontent').hide();
		$('#content-'+$(this).attr('id').replace('tab-', '')).show();
	});
	
	$('#tab-1').click(function(){                
            if ($('#content-1').html() == '') {
                tableDiv();
                $.getJSON('../datacenter/table', data,
                        function(tables){
                            $(tables.tabela).each(function(i, table){                                                
                                $('#table-view').append(montaTabela(table, i));
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
        
        $('#tab-3').click(function(){
            if($('#content-3').html() == ''){
                spreadSheetDivs();
                $.getJSON('../datacenter/spreadsheet', data,
                        function(spreadsheet){
                            //console.log(spreadsheet);
                            mostraPlanilha(spreadsheet);
                        });
            }
        });
        
        $("#tab-4").click(function(){
            if($("#content-4").html() == ''){
                tableStatiticDiv(); 
                $.getJSON('../datacenter/statistics', data, 
                    function(tables){
                        $(tables.tabela).each(function(i, table){                                                
                            $('#table-statistic-view').append(montaTabela(table, i));
                        });
                    });
            }
        });
	
	$('.confirmar').click(function(){
		
		if ($('#subgrupo .options li.sel').length <= 1) {
			
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
				|| data.fonte == undefined
				|| data.ano == undefined) {

				advise('É necessário selecionar os campos corretamente.');
				return false;
			} else {
				
				if ($('#grupo .options ul li.sel').html() == 'Comércio Internacional'
					&& (data.origem == undefined || data.destino == undefined)) {
						advise('É necessário selecionar os campos de Origem e Destino');
						return false;
				} else if (data.origem == undefined && data.destino == undefined) {
					advise('É necessário selecionar um valor em Origem ou Destino');
					return false;
				}
				
			}
                        
                                                      if($("#grupo .options ul li.sel").html() != 'Comércio Internacional'){
                                                          if (data.origem == undefined || data.origem.length == 0) data.origem = 0;
                                                          if (data.destino == undefined || data.destino.length == 0) data.destino = 0;
                                                      }
			
			console.log(data);
			
		} else {
			
			datas = [];
			
			$('#subgrupo .options ul li.sel').each(function(){
				
				group = $(this).parents('ul').find('.sg').html();
				subgroup = $(this).html();
				
				data = {
					'subgrupo': [],
					'tipo': [],
					'variedade': [],
					'origem': [],
					'destino': [],
					'fonte': []
				}

				// Pega os campos que foram selecionados
				data.subgrupo.push($(this).attr('id'));
				
				$('#tipo .options li.sel').each(function(){
					if ($(this).parents('ul').find('.sg').html() == group
						|| $(this).parents('ul').find('.sg').html() == subgroup) {
						data.tipo.push($(this).attr('id'));
					}
				});

				$('#variedade .options li.sel').each(function(){
					if ($(this).parents('ul').find('.sg').html() == group
						|| $(this).parents('ul').find('.sg').html() == subgroup) {
						data.variedade.push($(this).attr('id'));
					}
				});

				$('#origem .options li.sel').each(function(){
					if ($(this).parents('ul').find('.sg').html() == group
						|| $(this).parents('ul').find('.sg').html() == subgroup) {
						data.origem.push($(this).attr('id'));
					}
				});

				$('#destino .options li.sel').each(function(){
					if ($(this).parents('ul').find('.sg').html() == group
						|| $(this).parents('ul').find('.sg').html() == subgroup) {
						data.destino.push($(this).attr('id'));
					}
				});
				
				$('#fonte .options li.sel').each(function(){
					if ($(this).parents('ul').find('.sg').html() == group
						|| $(this).parents('ul').find('.sg').html() == subgroup) {
						data.fonte.push($(this).attr('id'));
					}
				});
				
				if (data.subgrupo.length == 1) data.subgrupo = data.subgrupo[0];
				else if (data.subgrupo.length == 0) data.subgrupo = 0;
				if (data.tipo.length == 1) data.tipo = data.tipo[0];
				else if (data.tipo.length == 0) data.tipo = 0;
				if (data.variedade.length == 1) data.variedade = data.variedade[0];
				else if (data.variedade.length == 0) data.variedade = 0;
				if (data.origem.length == 1) data.origem = data.origem[0];
				else if (data.origem.length == 0) data.origem = 0;
				if (data.destino.length == 1) data.destino = data.destino[0];
				else if (data.destino.length == 0) data.destino = 0;
				if (data.fonte.length == 1) data.fonte = data.fonte[0];
				else if (data.fonte.length == 0) data.fonte = 0;
				
				datas.push(data);
				
			});
			
			var error = false;
			
			$(datas).each(function(i, data){
				
				if (data.tipo == undefined
					|| data.variedade == undefined
					|| data.fonte == undefined) {

					advise('É necessário selecionar os campos correspondentes ao sub-grupo <strong>'+
							$('#subgrupo .options li[id='+data.subgrupo+']').html()+'</strong>');
					error = true;
					return false;
				} else {

					if (data.subgrupo == 1
						&& (data.origem == undefined || data.destino == undefined)) {
							advise('É necessário selecionar os campos de Origem e Destino correspondentes'+
							'ao sub-grupo <strong>'+$('#subgrupo .options li[id='+data.subgrupo+']').html()+'</strong>');
							error = true;
							return false;
					} else if (data.origem == undefined && data.destino == undefined) {
						advise('É necessário selecionar um valor em Origem ou Destino correspondente ao'
						+ ' sub-grupo <strong>'+$('#subgrupo .options li[id='+data.subgrupo+']').html()+'</strong>');
						error = true;
						return false;
					}

				}
				
			});
			
			if (error) { return false; }
			
			data = {"0": datas[0], "1": datas[1], "ano": [$('#de').val(), $('#ate').val()]};
			
			console.log(data);
			
		}
		
		$('.tabcontent').html('');                
		
		if ($('#tab-1.sel').length == 1) {
                        tableDiv();
			// Tabela
			$.getJSON('../datacenter/table', data,
				function(tables){
					$(tables.tabela).each(function(i, table){
						$('#table-view').append(montaTabela(table, i));
					});
				});
		} else if ($('#tab-2.sel').length == 1) {
			// Grafico
			$.getJSON('../datacenter/chart', data,
				function(chart){
					mostraGrafico(chart);
				});
		} else if ($('#tab-3.sel').length == 1) {
                        spreadSheetDivs();
			// Excel
                        $.getJSON('../datacenter/spreadsheet', data,
                                function(spreadsheet){
                                    mostraPlanilha(spreadsheet);
                                });
		} else if ($('#tab-4.sel').length == 1) {
			// Estatísticas
                        tableStatiticDiv(); 
                        $.getJSON('../datacenter/statistics', data, 
                            function(tables){
                                $(tables.tabela).each(function(i, table){                                                
                                    $('#table-statistic-view').append(montaTabela(table, i));
                                });
                            });                        
		}
		
		return false;
	});
	
	// Mostra a primeira aba
	$('.tab:first').trigger('click');
	
});

function spreadSheetDivs(){
    var view = '<div id="spreadsheet-view"></div>';
    var link = '<div id="spreadsheet-link"></div>';
    $("#content-3").html(view + link);
}

function mostraPlanilha(json){
    if(json.status){                
        var spreadsheetPath = json.planilha.split("spreadsheet/");
        var spreadsheetFilename = spreadsheetPath[1];
        var link = "<a class='spreadsheet-link' href='"+json.planilha+"'>"+spreadsheetFilename+"</a>";
        $("#spreadsheet-view").append(json.asHtml);
        $("#spreadsheet-link").append("<span class='spreadsheet'>Clique aqui para baixar sua planilha: " + link + "</span>");
    }
}

function tableDiv(){
    var div = "<div id='table-view'></div>";    
    $("#content-1").html(div);
}

function tableStatiticDiv(){
    var div = "<div id='table-statistic-view'></div>"
    $("#content-4").html(div);
}

function montaTabela(json, i) {
        var subgroups = $('#subgrupo .options li.sel');        
        //console.log("["+i+"] => " + $(subgroups[i]).text());        
        table = "<span class='subgroup-name'>"+$(subgroups[i]).text()+"</span>";
	table += '<table id="datatable">';

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
		
                                    table += '                <td>'+column.font+'</td>';
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
		advise('Houve um problema na geração do gráfico: ' + json.message);
	} else {
		var myChart = new FusionCharts( "fusion/"+json.typeChart, "myChartId", "730", "413", "0", "1" );
		myChart.setDataXML(json.chart);
		myChart.render("grafico");
	}
}

function advise(text) {
	$('#advise p').html(text);
	$('#advise').css('margin-top', (-1 * $('#advise').height()) + 'px');
	$('#advise').show();
}