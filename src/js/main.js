//Funcion para cambiar contraseña
function cambiarcontra(id,Nombre){
 $("#identida").val(id);

 $('#Modal_titulo_cambio').html('Cambiar Contraseña a usuario: '+Nombre)
 $("#Modal_cambio").modal()
}





//Funcion para mostrar contraseña
function mostrarPassword(){
   var cambio = document.getElementById("txtPassword");
   if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
   }else{
     cambio.type = "password";
     $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
  }
}

//





    //evento de formulario para enviar la info a la bd 

$("#form_cambio").on("submit",function(e){

    e.preventDefault();
    var pass=$('#txtPassword').val();
    $('#txtPassword').val(btoa(pass));
    $.ajax({
        url:'Backend/Controller.php',
        method:'POST',
        data: new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success: function(data){
            swal({
                title: "Éxito",
                text: "Se cambio correctamente su contraseña",
                icon: "success",
            }).then((seguro) => {
                location.reload();
            })
        },
        error:function(XMLHttpRequest,textStatus, errorThrown){
            $("#alerta").html("<div class='alert alert-danger'>Error no se pudo ejecutar la consulta</div> ");
        }
    })

});




    function right(str, chr) {
       return str.slice(str.length-chr,str.length);
    }

    function left(str, chr) {
       return str.slice(0, chr - str.length);
    }


function cargar(nombrellamada,url,controlador){
    $.post('Backend/'+controlador+'.php',{
        request:'Listar',
        tabla:nombrellamada

    }).done(function(response){


        $.post(url,{
            response:JSON.stringify(response)

        }).done(function(response){
            $('#main').html(response);
            document.body.style.overflow = 'auto';

        }).fail(function(error){
            swal("error",'Fallo al traer la pagina','error');
        });

    }).fail(function(error){
        swal("error",'No se puede obtener los datos','error');
    });


}


function verificar() {

 if (window.location.href.slice(-1)=="#") {
   if (typeof window.history.replaceState == 'function') { history.replaceState({}, '', window.location.href.slice(0, -1)); }    
}
 document.body.style.overflow = 'auto';
}



var letras_mayusculas="ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
var caracteres="!#$%&/().-,*";
var numeros="123456789";

function tiene_mayusculas(texto){
   for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}
function tiene_caracter(texto){
   for(i=0; i<texto.length; i++){
      if (caracteres.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}
function tiene_numero(texto){
   for(i=0; i<texto.length; i++){
      if (numeros.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

var mes=["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
function inicio(){

    var atendidos=0,
        reprogramadas=0,
        NSP=0,
        reservadas=0;
    $.post('../../Backend/Controller.php',{
        request:'inicio'
    }).done(function(response){
        $("#Cita_Hoy").html(response.citas[0].Conteo);
        $("#Cita_Mañana").html(response.citas[1].Conteo);

        var citames=response.data;

        for (var i = 0; i < citames.length; i++) {
            switch (citames[i].estado) {
                case 'NSP':
                    NSP=citames[i].Conteo;
                    break;
                case 'Atendido':
                    atendidos=citames[i].Conteo;
                    break;
                case 'Reprogramado':
                    reprogramadas=citames[i].Conteo;
                    break;
                case 'Cancelado':
                    NSP=citames[i].Conteo;
                    break;
                case 'Reservado':
                    reservadas=citames[i].Conteo;
                    break;
                default:
                    // statements_def
                    break;
            }
        }
        $("#Citas_Reservadas").html(reservadas);
        $("#Citas_Atendidas").html(atendidos);
        $("#Citas_NSP").html(NSP);
        $("#Citas_Reprogramadas").html(reprogramadas);




        //graficooooooooooooooooooooooooooooooo

        var citasgrafico=response.citasgrafico;
        var labels=[], citas1=[], citas2=[], citas3=[];
        for (var i = 0; i < citasgrafico.length; i++) {
            labels.push(mes[citasgrafico[i].mes]+" "+citasgrafico[i].año)
            citas1.push(citasgrafico[i].citas)
            citas2.push(citasgrafico[i].atendido)
            citas3.push(citasgrafico[i].cancelada)
        }


        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Programadas",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "#DD4578",
                    pointRadius: 3,
                    pointBackgroundColor: "#DD4578",
                    pointBorderColor: "#DD4578",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "#DD4578",
                    pointHoverBorderColor: "#DD4578",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: citas1,
                },
                    {
                        label: "Atendidas",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "#0FC0C9",
                        pointRadius: 3,
                        pointBackgroundColor: "#0FC0C9",
                        pointBorderColor: "#0FC0C9",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#0FC0C9",
                        pointHoverBorderColor: "#0FC0C9",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: citas2,
                    },
                    {
                        label: "Canceladas",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "#FF0000",
                        pointRadius: 3,
                        pointBackgroundColor: "#FF0000",
                        pointBorderColor: "#FF0000",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#FF0000",
                        pointHoverBorderColor: "rgb(231, 74, 59,1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: citas3,
                    }
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },

                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 8,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '' + number_format(value);
                            }
                        },
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 10
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: true
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });



//medios de citaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        var graficoPie=response.medioscitas;
        var labelPie=[],medio=[];
        for (var i = 0; i < graficoPie.length; i++) {
            labelPie.push(graficoPie[i].estado);
            medio.push(graficoPie[i].conteo)

        }


        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',

            data: {
                labels: labelPie,
                datasets: [{
                    data: medio,
                    backgroundColor: ['#DD4578', '#0FC0C9','#2e59d9'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true
                },


            },
        });



    }).fail(function(error){
        swal("error",'No se puede obtener los datos','error');
    });



    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
}
