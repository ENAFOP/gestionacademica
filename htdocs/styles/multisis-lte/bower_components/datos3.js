/*

	JOSÉ MARIO LOPEZ LEIVA
	2017
	marioleiva2011@gmail.com
*/
var numeroAnormales = $("#numeroAnormales").val();
var numeroDefinitivas = $("#numeroDefinitivas").val();

//console.log(reservas.toString());
//var mayor = Math.max(...reservas); //obtengo el numero mayor, para poder ajustar la escala de la gráfica
var mayor = $("#mayorValor").val();


var barData = 
			{
                labels : ["Anormales", "Definitivas"],
                datasets : [
                    {
                        fillColor : "#48A497",
                        strokeColor : "#48A4D1",
                        data : [numeroAnormales,numeroDefinitivas]
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
    myChart.datasets[0].bars[1].fillColor = "rgba(229,12,12,0.7)";
myChart.datasets[0].bars[1].strokeColor = "rgba(229,12,12,1)";
myChart.update();