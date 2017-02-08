function numeroParaMoeda(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function ajax(e, url, data, sucessResult ){
    e.preventDefault();
    token = $('input[name=_token]').val();

    $.ajax({
         url : url,
         headers: {'X-CSRF-TOKEN': token},
         type : 'POST', 
         data: data,
         dataType: 'json',
         success: function(result){
            sucessResult(result);            
        }
    });
}

if(document.getElementById('btn-camera')){
    document.getElementById("btn-camera").addEventListener("click", function () {
        var canvas = document.getElementById("canvas"),
        context = canvas.getContext("2d"),
        video = document.getElementById("video"),
        videoObj = {"video": true},
        errBack = function (error) {
            console.log("Erro ao capturar imagem: ", error.code);
        };
        if (navigator.getUserMedia) {
            navigator.getUserMedia(videoObj, function (stream) {
                video.src = stream;
                video.play();
            }, errBack);
        } else if (navigator.webkitGetUserMedia) {
            navigator.webkitGetUserMedia(videoObj, function (stream) {
                video.src = window.webkitURL.createObjectURL(stream);
                video.play();
            }, errBack);
        } else if (navigator.mozGetUserMedia) {
            navigator.mozGetUserMedia(videoObj, function (stream) {
                video.src = window.URL.createObjectURL(stream);
                video.play();
            }, errBack);
        }
    }, false);

    document.getElementById("okFoto").addEventListener("click", function () {
        canvas.getContext("2d").drawImage(video, 0, 0, 400, 300);
    });
}

$(document).ready(function(){
    var SERVER = window.location.host;
    var URL = window.location.pathname.split('/');

    if(SERVER == 'localhost'){
        URL = URL[3];
    }
    
    // Select 2
    $('.select2').select2();
    
    // Camera
    $('#okFoto').click(function(e){
        $('#imagem-preview').show();
        
        $('input[name=foto]').attr('value', 'Imagem capturada com sucesso!');
        var imageData = canvas.toDataURL('image/png');
        document.getElementsByName("codImagem")[0].setAttribute("value", imageData)
    });
    
    if($('#canvas').length){
        $('#canvas').each(function(){
            var canvas = document.getElementById("canvas");
            var dataSrc = $(this).data('src');            
            var context = canvas.getContext('2d');
            var imageObj = new Image();

            imageObj.onload = function() {
              context.drawImage(imageObj, 0, 0);
            };
            imageObj.src = dataSrc;
            
            
        });
    }

    if($('#calendar').length){
        $('#calendar').fullCalendar({
            lang: 'pt-br'
        });

        $('a[href=#agenda]').click(function(){
            setTimeout(function(){
                $('.fc-today-button').click()
            }, 500);
        });
    }

    if($('button.verTurmas').length)
        $('button.verTurmas').click(function(){
            $('div.verTurmas').slideToggle(500);
        });
    
    if($('button.addHorario').length){
        var numBtn = 1;
        
        $('div.dia_semana').first().show();
        $('div.hora_inicio').first().show();
        $('div.hora_fim').first().show();
        
        $('button.addHorario').click(function(){
            $('div.dia_semana').eq(numBtn).fadeIn();
            $('div.hora_inicio').eq(numBtn).fadeIn();
            $('div.hora_fim').eq(numBtn).fadeIn();
            
            if(numBtn == 4){
                $(this).parent().hide();
            }
           
            numBtn++;
        });
    }

    if($('input[name=htmlTable]').length){
        $('input[name=htmlTable]').val($('.box-body').html());
    }

    if($('#tabela_cadastro, .tabData').length){
        $('#tabela_cadastro, .tabData').DataTable({   
            "ordering" : false,
            "oLanguage": {
               "sProcessing": "Aguarde enquanto os dados são carregados ...",
               "sLengthMenu": "Mostrar _MENU_ registros",
               "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
               "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
               "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
               "sInfoFiltered": "",
               "sSearch": "Procurar",
               "oPaginate": {
                  "sFirst":    "Primeiro",
                  "sPrevious": "Anterior",
                  "sNext":     "Próximo",
                  "sLast":     "Último"
               }
            }                              
        });
    }

    if($('.formFone').length)
        $('.formFone').inputmask('(99) 9999-9999[9]', { numericInput: true });

    if($('.formCPF').length)
        $('.formCPF').inputmask('999.999.999-99', { numericInput: true });

    if($('.formCEP').length)
        $('.formCEP').inputmask('99999-999', { numericInput: true });

    if($('.formDate').length)
        $('.formDate').inputmask('99/99/9999', { numericInput: true });

    if($('.formRG').length)
        $('.formRG').inputmask('[99999]9999999', { numericInput: true });

    //if($('.formDin').length)
        //$('.formDin').inputmask('R$ [999.999],99', { numericInput: true });

    $('.formDin').inputmask('decimal',
      { 'alias': 'numeric',
        'groupSeparator': '.',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ",",
        'digitsOptional': false,
        'allowMinus': false,
        'prefix': '$ ',
        'placeholder': '0'
      });

    $('button[type=refresh]').click(function(event){
        event.preventDefault();
        window.location.reload();
    });

    if($('.dataTable').length)
        $('.dataTable').DataTable(); 
    
    $('select.change').change(function(){
        if($(this).val() == 'change'){
            $('div.change').slideDown();
        }else{
            $('div.change').slideUp();
        }
    });
    
    $('.desc_select').change(function(){
        var descVal = $(this).val();
        
        switch(descVal){
            case 'mensalidade':
                $('div.mensalidade').slideDown();   
                break;
            default:
                $('div.mensalidade').slideUp();
        }
    });
    
    if($('select.change').length && $('select.change').val() == 'change'){
        $('div.change').slideDown();
    }
    
    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%' // optional
    });

    /* Executa a requisição quando o campo CEP perder o foco */
    $('.formCEP').blur(function(e){
        ajax(e, '../consultaCEP', 'cep=' + $('.formCEP').val(), function(result){
            if(result.sucesso == 1){
                $('input[name=endereco]').val(result.rua);
                $('input[name=bairro]').val(result.bairro);
                $('input[name=cidade]').val(result.cidade);
            }else{
                $('input[name=endereco]').val('CEP inválido');
                $('input[name=bairro]').val('CEP inválido');
                $('input[name=cidade]').val('CEP inválido');
            }
        });
        
        return false;
    });
    
    /* Executa a requisição quando o campo aluno for escolhido em contratos */
    $(document).on('change', 'select.desconto', function(e){
        ajax(e, 'getDesconto', 'usuario_id=' + $('select.desconto').val(), function(result){
            console.log(result);
            if(result.anuidade == '0,00'){
                $('div.desconto').html('<p class="alert alert-warning alert-dismissable"><button type="button" class="close" style="color:#ffffff;opacity:1;" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-warning"></i> Aluno não matrículado.</p>');
                
                $('input.anuidade').val('');
                $('input[name=anuidade]').val('');
                $('.tabela_anuidades').slideUp();
            }else{
                $('div.desconto').html('<p class="alert alert-success alert-dismissable"><button type="button" class="close" style="color:#ffffff;opacity:1;" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-check"></i>'
                   + result.desc_desconto
                + '</p>');

                $('.tabela_anuidades tbody').html('');
                
                for (var key in result.turmas) {
                    var obj = result.turmas[key];
                    $('.tabela_anuidades tbody').append('<tr><td>' + obj.turma + '</td>'
                            + '<td>' + obj.anuidade + '</td></tr>');
                }
                
                $('.total_anuidade').html(result.anuidade);
                $('.tabela_anuidades').slideDown();
                $('input.anuidade').val(result.anuidade);
                $('input[name=anuidade]').val(result.anuidade);
            }
        });
        
        return false;
    });
    

    $('.calculaMensalidade').click(function(e){
        ajax(e, 'getMensalidade', 'usuario_id=' + $('.usuario_id').val(), function(result){
            $('#modalMensalidade .modal-body tbody').html('');
                var total = parseFloat(0.00).toFixed(2);
                var subtotal = parseFloat(0.00).toFixed(2);
                
                for (i = 0; i < result.length; i++) {
                    var valor = result[i].valor;
                    $('#modalMensalidade .modal-body tbody').append('<tr><td>' + result[i].turma + '</td><td>' + valor + '</td></tr>');
                    
                    subtotal = parseFloat(valor.replace(',','.')).toFixed(2);
                    total = (parseFloat(total) + parseFloat(subtotal));
                }

                $('input[name=valor]').val(parseFloat(total).toFixed(2).replace('.',','));
                $('#modalMensalidade .modal-body tbody').append('<tr><td><strong>Total</strong></td><td>' + parseFloat(total).toFixed(2).replace('.',',') + '</td></tr>');
        });
    });
    
    
    $('.btnEmitirBoletorTurma').click(function(e){
        ajax(e, 'emitir-boletos', 'turma_id=' + $('.turma_id').val(), function(result){
            $('#modalBoletos .modal-body tbody').html('');     
            for (var key in result) {
                var obj = result[key];
                if(obj.status !== 'pago'){
                    var edit = '<a href="boletos/' + key + '/edit/" title="Editar" > <i class="fa fa-edit"></i></a>';
                }else{
                    var edit = '';
                }

                $('#modalBoletos .modal-body tbody').append('<tr>'
                        + '<td>' + key + '</td>'
                        + '<td>' + obj.nome + '</td>'
                        + '<td>' + obj.valor + '</td>'
                        + '<td>' + obj.status + '</td>'
                        + '<td>'
                        + '<a href="../boletos/imprimir/' + key + '" title="Imprimir" target="new"><i class="fa fa-print"></i> </a>'
                        + edit
                        + '</td>'
                        + '</tr>');
            }
        });
    });
    
    $('.verBoletosRemessaRetorno').click(function(e){
       ajax(e, $(this).attr('href'), 'remessa_retorno_id=' + $(this).attr('rel'), function(result){
            $('#modalBoletos .modal-body tbody').html('');

            for (var key in result) {
                var obj = result[key];
                $('#modalBoletos .modal-body tbody').append('<tr>'
                        + '<td>' + key + '</td>'
                        + '<td>' + obj.nome + '</td>'
                        + '<td>' + obj.valor + '</td>'
                        + '<td>' + obj.status + '</td>'
                        + '<td>'
                        + '<a href="../boletos/imprimir/' + key + '" title="Imprimir" target="new"><i class="fa fa-print"></i> </a>'
                        + '</td>'
                        + '</tr>');
            }
        });
    });
    
    $('.alunoAcessoManual').change(function(e){
       ajax(e, '../turmas/consultaByAluno', 'aluno_id=' + $(this).val(), function(result){
           console.log(result);
            $('.turmaAcessoManual').html('');

            for (var key in result) {
                var obj = result[key];
                $('.turmaAcessoManual').append('<option value="' + key + '">' + obj + '</option>');
            }
        });
    });
});
