<table>
	<tr>
		<td>Bonjour,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Votre RDV avec le docteur {{$doctor->last_name}} est confirmé.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Date : {{$date_email}}.</td>
	</tr>
	<tr>
		<td>Lieu : {{$address}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>En cas d'imprévu, vous pouvez annuler ce RDV à partir de cette page {{url("/account/appointments")}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>L'équipe Global Santé.</td>
	</tr>
	
</table>