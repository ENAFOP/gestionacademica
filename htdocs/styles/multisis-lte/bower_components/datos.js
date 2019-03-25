/*

	JOSÉ MARIO LOPEZ LEIVA
	2017
	marioleiva2011@gmail.com
*/


//OBTENER DEL FORMULARIO que está en class.EstadisticasDepartamentales.php
var numeroAs = $("#numeroAs").val();
var numeroBs = $("#numeroBs").val();
var numeroCs = $("#numeroCs").val();
var numeroDs = $("#numeroDs").val();
var numeroEs = $("#numeroEs").val();
var numeroFs = $("#numeroFs").val();
var numeroGs = $("#numeroGs").val();
var numeroHs = $("#numeroHs").val();
var numeroIs = $("#numeroIs").val();
var numeroJs = $("#numeroJs").val();
var numeroKs = $("#numeroKs").val();
var numeroLs = $("#numeroLs").val();


//console.log(reservas.toString());
//var mayor = Math.max(...reservas); //obtengo el numero mayor, para poder ajustar la escala de la gráfica
var mayor = $("#mayorValor").val();
//console.log(mayor);
            // bar chart data
            var barData = 
			{
                labels : ["A","B","C","D","E","F","G","H","I","J","K","L"],
                datasets : [
                    {
                        fillColor : "#f4b342",
                        strokeColor : "#f4b342",
						label: 'Número de resoluciones que se categorizan dentro de cada literal de las prohibiciones éticas de la LEG',
                        data : [numeroAs,numeroBs,numeroCs,numeroDs,numeroEs,numeroFs,numeroGs,numeroHs,numeroIs,numeroJs,numeroKs,numeroLs]
                    }
				
                ]
            }
            //get bar chart canvas
            var income = document.getElementById("graficoBarras").getContext("2d");
            //draw bar chart
			var config= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : mayor,
				scaleStartValue : 0
				
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
}			
    var myChart= new Chart(income).Bar(barData,config);
			//document.getElementById("leyenda").innerHTML = grafico.generateLegend();
//document.getElementById('js-legend').innerHTML = myChart.generateLegend();

