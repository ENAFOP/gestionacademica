/*

	JOSÉ MARIO LOPEZ LEIVA
	2017
	marioleiva2011@gmail.com
*/


var numeroSinLugar = $("#numeroSinLugar").val();
var numeroSanciona = $("#numeroSanciona").val();
var numeroImprocedente = $("#numeroImprocedente").val();
var numeroNoSanciona = $("#numeroNoSanciona").val();
var numeroSobreseimiento = $("#numeroSobreseimiento").val();
var numeroInadmisible = $("#numeroInadmisible").val();
var numeroDesistimiento = $("#numeroDesistimiento").val();

//console.log(reservas.toString());
//var mayor = Math.max(...reservas); //obtengo el numero mayor, para poder ajustar la escala de la gráfica
var mayor = $("#mayorValor").val();


var pieData = [
				{
					value: numeroSinLugar,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "Sin lugar a la apertura del procedimiento"
				},
				{
					value: numeroSanciona,
					color: "#ffac38",
					highlight: "#526868",
					label: "Sanciona"
				},
				{
					value: numeroNoSanciona,
					color: "#18a547",
					highlight: "#37c9ff",
					label: "No sanciona"
				},
				{
					value: numeroImprocedente,
					color: "#f44242",
					highlight: "#f44242",
					label: "Improcedente"
				},
				{
					value: numeroSobreseimiento,
					color: "#d9f441",
					highlight: "#37c9ff",
					label: "Sobreseimiento"
				},
				{
					value: numeroInadmisible,
					color: "#41f47c",
					highlight: "#37c9ff",
					label: "Inadmisible"
				},
				{
					value: numeroDesistimiento,
					color: "#41f4e8",
					highlight: "#37c9ff",
					label: "Desistimiento"
				}
			

			];
			
window.onload = function(){
				var pastel2 = document.getElementById("graficoPastel").getContext("2d");
				window.myPie = new Chart(pastel2).Pie(pieData);
				
			};
