<table>
	<tr>
		<td>Bonjour,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Un RDV a été pris avec le docteur {{$doctor->first_name}}.</td>
	</tr>
	<tr>
		<td>Date : {{$date_email}} à {{$time}}.</td>
	</tr>
	<tr>
		<td>Lieu : {{$address}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>Veuillez confirmer votre compte en cliquant sur ce lien, il vous sera demandé de soumettre un mot de passe pour la création de votre compte : {{ url('/patient/password/reset') }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Ensuite, si vous souhaitez annuler ce RDV, vous pourrez le faire à partir de cette page {{url("/account/appointments")}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>L'équipe Global Santé.</td>
	</tr>
	
</table>