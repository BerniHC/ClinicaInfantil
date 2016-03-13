
	function drawDiente(svg, parentGroup, diente){
		if(!diente) throw new Error('Error no se ha especificado el diente.');
		
		var x = diente.x || 0,
			y = diente.y || 0;
		
		var defaultPolygon = {fill: 'white', stroke: 'gray', strokeWidth: 0.5, style: 'cursor:pointer'};
		var dienteGroup = svg.group(parentGroup, {transform: 'translate(' + x + ',' + y + ')'});

		var action = $(svg).attr('data-action');

		var caraSuperior = svg.polygon(dienteGroup,
			[[0,0],[20,0],[15,5],[5,5]],  
		    defaultPolygon);
	    caraSuperior = $(caraSuperior).data('cara', 'S');
		
		var caraInferior =  svg.polygon(dienteGroup,
			[[5,15],[15,15],[20,20],[0,20]],  
		    defaultPolygon);			
		caraInferior = $(caraInferior).data('cara', 'I');

		var caraDerecha = svg.polygon(dienteGroup,
			[[15,5],[20,0],[20,20],[15,15]],  
		    defaultPolygon);
	    caraDerecha = $(caraDerecha).data('cara', 'D');
		
		var caraIzquierda = svg.polygon(dienteGroup,
			[[0,0],[5,5],[5,15],[0,20]],  
		    defaultPolygon);
		caraIzquierda = $(caraIzquierda).data('cara', 'Z');		    
		
		var caraCentral = svg.polygon(dienteGroup,
			[[5,5],[15,5],[15,15],[5,15]],  
		    defaultPolygon);	
		caraCentral = $(caraCentral).data('cara', 'C');		    
	    
	    var caraCompleto = svg.text(dienteGroup, 6, 30, diente.id.toString(), 
	    	{fill: 'gray', stroke: 'gray', strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal;cursor:pointer'});
    	caraCompleto = $(caraCompleto).data('cara', 'X');
    	
		//Busco los tratamientos aplicados al diente
    	var tratamientosAplicadosAlDiente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function (t) {
    	    return t.diente == diente.id;
    	});

		var caras = [];
		caras['S'] = caraSuperior;
		caras['C'] = caraCentral;
		caras['X'] = caraCompleto;
		caras['Z'] = caraIzquierda;
		caras['D'] = caraDerecha;
		caras['I'] = caraInferior;

		for (var i = tratamientosAplicadosAlDiente.length - 1; i >= 0; i--) {
			var t = tratamientosAplicadosAlDiente[i];
			caras[t.cara].attr('fill', '#52BCBF');
		};

		$.each([caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto], function (index, value) {
		    value.click(function () {
		        var me = $(this);
		        var cara = me.data('cara');
		        var type = $('#odontogram').attr('data-type');

		        if (type == 'by-expedient') {
		            var piece = 'P' + diente.id + cara;
		            var expedient_id = $('#odontogram').attr('data-expedient');
		            var url = MAIN_PATH + '/admin/expedients/' + expedient_id + '/treatments/' + piece;

		            $('#odontogram-modal tbody').text('');
		            $.getJSON(url, function (data) {
		                if (data.length == 0) {
		                    $('#odontogram-modal tbody').append('<tr></tr>');
		                    $('#odontogram-modal tbody tr').last().append('<td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</tr>');
		                }
		                $.each(data, function (key, value) {
		                    var date = moment(value.created_at, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY hh:mm a');
		                    $('#odontogram-modal tbody').append('<tr></tr>');
		                    $('#odontogram-modal tbody tr').last().append('<td>' + value.piece + '</tr>');
		                    $('#odontogram-modal tbody tr').last().append('<td>' + value.description + '</tr>');
		                    $('#odontogram-modal tbody tr').last().append('<td>' + date +'</tr>');
		                });
		                $('#odontogram-modal').modal('toggle');
		            });
		        }
		        if (type == 'by-treatment') {
		            $('[name=tooth]').val(diente.id);
		            $('[name=face]').val(cara);

		            $('#odontogram-modal').modal('toggle');
		        }
		    }).mouseenter(function () {
		        var me = $(this);
		        me.data('oldFill', me.attr('fill'));
		        me.attr('fill', '#C2E9FF');
		    }).mouseleave(function () {
		        var me = $(this);
		        me.attr('fill', me.data('oldFill'));
		    });
		});
	};

	function renderSvg(){
		console.log('update render');

		var svg = $('#odontogram').svg('get').clear();
		var parentGroup = svg.group({transform: 'scale(1.5)'});
		var dientes = vm.dientes();
		for (var i =  dientes.length - 1; i >= 0; i--) {
			var diente =  dientes[i];
			var dienteUnwrapped = ko.utils.unwrapObservable(diente); 
			drawDiente(svg, parentGroup, dienteUnwrapped);
		};
	}

	//View Models
	function DienteModel(id, x, y){
		var self = this;

		self.id = id;	
		self.x = x;
		self.y = y;		
	};

	function ViewModel(){
		var self = this;

		self.tratamientosAplicados = ko.observableArray([]);

		self.quitarTratamiento = function (tratamiento) {
		    self.tratamientosAplicados.remove(tratamiento);
		    renderSvg();
		}

		//Cargo los dientes
		var dientes = [];
		//Dientes izquierdos
		for (var i = 0; i < 8; i++)
			dientes.push(new DienteModel(18 - i, i * 25 + 1, 1));	
		
		for (var i = 0; i < 5; i++)
			dientes.push(new DienteModel(55 - i, i * 25 + 75, 1 * 40));	
		
		for (var i = 0; i < 5; i++)
			dientes.push(new DienteModel(85 - i, i * 25 + 75, 2 * 40));	
		
		for (var i = 0; i < 8; i++)
			dientes.push(new DienteModel(48 - i, i * 25 + 1, 3 * 40));	
		
		//Dientes derechos
		for (var i = 0; i < 8; i++)
			dientes.push(new DienteModel(21 + i, i * 25 + 210, 1));	
		
		for (var i = 0; i < 5; i++)
			dientes.push(new DienteModel(61 + i, i * 25 + 210, 1 * 40));	
		
		for (var i = 0; i < 5; i++)
			dientes.push(new DienteModel(71 + i, i * 25 + 210, 2 * 40));	
		
		for (var i = 0; i < 8; i++)
			dientes.push(new DienteModel(31 + i, i * 25 + 210, 3 * 40));	
		
		self.dientes = ko.observableArray(dientes);
	};

	var nodata = $('tr.no-data').clone();

    // Funcion Remover Tratamiento
    function removerTratamiento() {
        tratamiento_id = $(this).attr('data-treatment');

        row = $(this).closest('tr');
        piece = $(row).find('[name="treatments[' + tratamiento_id + '][piece]"]').val();

        diente_id = piece.substr(1, 2);
        cara_id = piece.substr(3, 3);

        //Busco tratamiento
        var tratamiento = ko.utils.arrayFirst(vm.tratamientosAplicados(), function (t) {
            return t.diente == diente_id && t.cara == cara_id && t.tratamiento == tratamiento_id;
        });

        vm.quitarTratamiento(tratamiento);

        row.remove();

        if ($('#treatments>tbody tr').length == 0)
            nodata.appendTo(tbody);
    }
    
    // Aplicar tratamiento odontograma
    function agregarTratamiento(pieza, tratamiento_id) {
        diente_id = pieza.substr(1, 2);
        cara_id = pieza.substr(3, 3);

	    vm.tratamientosAplicados.push({
	        diente: diente_id,
	        cara: cara_id,
	        tratamiento: tratamiento_id
	    });
    }

    // Funcion Agregar Tratamiento
    function aplicarTratamiento() {
	    $('#odontogram-modal').modal('toggle');

	    // Cargar campos del formulario
	    diente = $('[name=tooth]').val();
	    cara = $('[name=face]').val();
	    tratamiento_id = $('[name=treatment] option:selected').val();
	    tratamiento = $('[name=treatment] option:selected').text();
	    observacion = $('[name=observations]').val();

	    // Limpiar formulario
	    $('[name=tooth]').val("");
	    $('[name=face]').val("");
	    $('[name=observations]').val("");

	    // Aplicar tratamiento odontograma
	    vm.tratamientosAplicados.push({
	        diente: diente,
	        cara: cara,
	        tratamiento: tratamiento_id
	    });
        
	    var btnDelete = $(
            '<button type="button" class="close pull-left remove-treatment" data-treatment="'
             + tratamiento_id + '" style="margin:0 10px 0 0"><span>&times;</span></button>')
            .click(removerTratamiento);

	    $('tr.no-data').remove();

	    tbody = $('#treatments>tbody');

	    tbody.append('<tr>');
	    $('#treatments>tbody tr:last-child').append('<td>');
	    $('#treatments>tbody tr:last-child td').append(
            '<input type="hidden" name="treatments[' + tratamiento_id + '][piece]" value="P' + diente + cara + '"/>');
	    $('#treatments>tbody tr:last-child td').append(btnDelete);
	    $('#treatments>tbody tr:last-child td').append(
            '<input type="hidden" name="treatments[' + tratamiento_id + '][observation]" value="' + observacion + '"/>');
	    $('#treatments>tbody tr:last-child td').append('<strong>P' + diente + cara + '</strong> ');
	    $('#treatments>tbody tr:last-child').append('<td>');
	    $('#treatments>tbody tr:last-child td:last-child').append(tratamiento);
	    $('#treatments>tbody tr:last-child').append('<td class="hidden-xs">');
	    $('#treatments>tbody tr:last-child td:last-child').append(observacion);

	    //Actualizo el SVG
	    renderSvg();
	}
    
	vm = new ViewModel();
	
	//Inicializo SVG
    $('#odontogram').svg({
        settings:{ width: '620px', height: '250px' }
    });

	ko.applyBindings(vm);

    // Eventos
	$("#add-treatment").click(aplicarTratamiento);
	$(".remove-treatment").click(removerTratamiento);

	//TODO: Cargo el estado del odontograma
	//renderSvg();
